import shodan
import sys
import json
import pycountry
import argparse
from pymongo import MongoClient

api_key = "ApWJ249AiARJ8PrEIPm6ZuGLrEV0wqdg"
api = shodan.Shodan(api_key)

def read_config(filename):
    with open(filename, "r") as f:
        config = json.load(f)
    return config

def connect_to_mongodb(database, collection):
    config = read_config("key.json")
    username = config["mongodb_username"]
    password = config["mongodb_password"]
    mongodb_uri = f"mongodb://{username}:{password}@localhost:27017/{database}"
    client = MongoClient(mongodb_uri)
    db = client[database]
    coll = db[collection]
    return coll

def is_valid_country_code(country_code):
    try:
        country = pycountry.countries.get(alpha_2=country_code.upper())
        return country is not None
    except:
        return False

def main(args):
    country_code = args.iso

    if not is_valid_country_code(country_code):
        print("Código de país inválido. Por favor, ingrese un código de país válido (por ejemplo, US para Estados Unidos).")
        sys.exit(1)

    search_filter = ""

    if args.V:
        vuln_id = args.V
        if vuln_id == "eternalblue":
            search_filter = "vuln:MS17-010"
        elif vuln_id == "bluekeep":
            search_filter = "vuln:CVE-2019-0708"
        elif vuln_id == "proxylogon":
            search_filter = "vuln:CVE-2021-26855"
        elif vuln_id == "proxyshell":
            search_filter = "vuln:CVE-2021-34473"
        else:
            print("ID de vulnerabilidad inválido.")
            sys.exit(1)
    elif args.no_auth:
        protocol = args.no_auth
        if protocol == "ftp":
            search_filter = '"220" "230 Login successful." port:21'
        elif protocol == "rfb":
            search_filter = '“authentication disabled” “RFB 003.008”'
        elif protocol == "vnc":
            search_filter = '“authentication disabled” port:5900,5901'
        else:
            print("Protocolo inválido.")
            sys.exit(1)
    elif args.sa:
        service_type = args.sa
        if service_type == "ssh":
            search_filter = "port:22"
        elif service_type == "web":
            search_filter = "port:80,443,8080,8443"
        elif service_type == "ftp":
            search_filter = "port:21"
        elif service_type == "mysql":
            search_filter = "port:3306"
        elif service_type == "rdp":
            search_filter = "port:3389"
        elif service_type == "all":
            search_filter = "has_vuln:true"
        else:
            print("Tipo de servicio inválido.")
            sys.exit(1)
    elif args.D:
        search_filter = f'hostname:*.{args.D}'

    search_filter += f' country:{country_code}'

    if args.limit:
        limit = args.limit
    else:
        limit = 100

    if args.O:
        offset = args.O
    else:
        offset = 0
        search_and_save_results(search_filter, limit, offset)

def search_and_save_results(search_filter, limit, offset):
    try:
        results = api.search(search_filter, page=offset, limit=limit)
        total_results = results['total']

        json_data = []

        for result in results["matches"]:
            vulnerabilities = []
            if "vulns" in result:
                for vuln_key in result["vulns"]:
                    vulnerabilities.append({
                        "vuln": vuln_key,
                        "cvss": result["vulns"][vuln_key]["cvss"]
                    })

            json_data.append({
                "ip_address": result["ip_str"],
                "hostname": result.get("hostnames", ["N/A"])[0] if result.get("hostnames", []) else "No se encontraron hostnames",
                "organization": result.get("org", "N/A"),
                "vulnerabilities": vulnerabilities if vulnerabilities else "No se identificaron vulnerabilidades públicas",
                "isp": result.get("isp", "N/A"),
                "city": result.get("location", {}).get("city", "N/A"),
                "domains": result.get("domains", []) if result.get("domains", []) else "No se encontraron dominios asociados"
            })

        with open("resultado.json", "w") as f:
            json.dump(json_data, f, indent=4)

        print("\nResultados guardados en 'resultado.json'.")

        db_collection = connect_to_mongodb("recon_db", "results")
        db_collection.insert_many(json_data)

    except shodan.APIError as e:
        print(f"Error: {e}")

if __name__ == "__main__":
    parser = argparse.ArgumentParser(description="C4ISR Recon")
    parser.add_argument('-iso', metavar='codigo del pais', required=True, help='Código del país')
    parser.add_argument('-V', metavar='id_vuln', help='ID de vulnerabilidad (eternalblue, bluekeep, proxylogon, proxyshell)')
    parser.add_argument('--no-auth', metavar='protocol', help='Protocolo sin autenticación (ftp, rfb, vnc, smb)')
    parser.add_argument('-sa', metavar='type', help='Tipo de servicio (ssh, web, ftp, mysql, rdp, all)')
    parser.add_argument('-D', metavar='tld', help='Dominio de nivel superior')
    parser.add_argument('-limit', metavar='limite', type=int, help='Límite de resultados de acuerdo con la API de Shodan')
    parser.add_argument('-O', metavar='offset', type=int, help='Establecer el offset')
    args = parser.parse_args()
    main(args)