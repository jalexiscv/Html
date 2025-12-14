import os
import sys
import pickle
import json

def busc(palabra_buscar, cache2, ruta_base):
    cache_file = "Cache/" + str(cache2) + ".pickle"

    if os.path.exists(cache_file):
        with open(cache_file, "rb") as f:
            cache = pickle.load(f)
    else:
        cache = {}

    cachekey=palabra_buscar+"_alfa"
    if cachekey in cache:
        matriz = cache[cachekey]
    else:
        matriz = []
        palabra_buscar = palabra_buscar.lower()
        for carpeta_actual, subcarpetas, archivos in os.walk(ruta_base):
            for archivo in archivos:
                if archivo.endswith(".txt"):
                    try:
                        with open(os.path.join(carpeta_actual, archivo), "r", encoding="utf-8", errors="ignore") as archivo_actual:
                            lineas = archivo_actual.readlines()
                            for num_linea, linea in enumerate(lineas, start=1):
                                linea_original = linea.rstrip()
                                linea = linea.lower()
                                palabras = linea.split()
                                if palabra_buscar in linea:
                                    ruta = os.path.join(carpeta_actual)
                                    inicio = max(0, num_linea - 5)
                                    fin = min(len(lineas), num_linea + 6)
                                    lineas_contexto = lineas[inicio:fin]
                                    linea_contexto = ""
                                    for i, linea_contexto_actual in enumerate(lineas_contexto, start=inicio+1):
                                        key = str(i)
                                        if i == num_linea:
                                            linea_contexto += "<span style='color:red;'>" + linea_contexto_actual.rstrip() + "</span><br>"
                                        else:
                                            linea_contexto += linea_contexto_actual.rstrip() + "<br>"
                                        vector = {
                                            "archivo": archivo,
                                            "ruta": ruta,
                                            "num_linea":  str(num_linea),
                                            "linea_contexto": linea_contexto
                                        }
                                        matriz[key] = vector
                        cache[cachekey] = matriz
                        with open(cache_file, "wb") as f:
                            pickle.dump(cache, f)
                    except:
                        continue

    return json.dumps(matriz)


if __name__ == "__main__":
    Palabra = sys.argv[1]
    rus = "breaches"
    resultado_json = busc(Palabra, Palabra, rus)
    print(resultado_json)