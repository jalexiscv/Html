import os
import sys
from urllib.parse import quote
def search_files_for_keyword(directory, keyword):
    results = []
    for root, _, files in os.walk(directory):
        for filename in files:
            path = os.path.join(root, filename)
            with open(path, 'r', encoding='utf-8') as file:
                for number, line in enumerate(file, start=1):
                    if keyword.lower() in line.lower():
                        fields = line.strip().split(":")
                        phone = fields[0]
                        sid = fields[1]
                        firstname = quote(fields[2])
                        lastname = quote(fields[3])
                        sex = fields[4]
                        placeofbirth = quote(fields[5])
                        placeofresidence = quote(fields[6])
                        company = quote(fields[7])
                        result = f"{path},{number},{phone},{sid},{firstname},{lastname},{sex},{placeofresidence},{placeofresidence},{company}"
                        results.append(result)
    return results

if __name__ == "__main__":
    current_directory = os.getcwd()
    directory = os.path.join(current_directory, 'colombia')
    keyword = sys.argv[1]
    #print(f"Search: {keyword}")
    if os.path.exists(directory):
        #print(directory)
        search_results = search_files_for_keyword(directory, keyword)
        #print(f"Se encontraron {len(search_results)} resultados para la palabra clave '{keyword}':")
        if search_results:
            #print(f"Resultados:")
            for result in search_results:
                print(result)
        else:
            print(f"No se encontró '{keyword}' en los archivos del directorio '{directory}'.")
    else:
        print(f"El directorio '{directory}' no existe.")



