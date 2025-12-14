# -*- coding: utf-8 -*-
import mysql.connector
import time

from mysql.connector import Error
from datetime import datetime


def uniqid():
    t = str(time.time()).replace('.', '')
    return t[:13]


def connect_to_database():
    try:
        connection = mysql.connector.connect(
            host='localhost',
            user='jalexiscv',
            password='94478998x',
            database='anssible_anssible'
        )
        if connection.is_connected():
            print("Conexión exitosa a la base de datos")
            return connection

    except Error as e:
        print("Error durante la conexión a la base de datos", e)


def insert_into_table(connection, sql_insert_query, data_tuple):
    cursor = connection.cursor()
    try:
        cursor.execute(sql_insert_query, data_tuple)
        connection.commit()
        print("Registro insertado exitosamente en la tabla")

    except Error as e:
        print("Error al insertar datos en la tabla MySQL", e)

    finally:
        cursor.close()


def email_exists(connection, email):
    cursor = connection.cursor()
    try:
        sql_query = """SELECT `mail` FROM `c4isr_mails` WHERE `email` = %s"""
        cursor.execute(sql_query, (email,))
        result = cursor.fetchone()
        if result is not None:
            return result[0]  # Retorna el valor del campo `mail`
        else:
            return False  # Retorna False si el correo electrónico no existe

    except Error as e:
        print(f"Error al verificar la existencia del email en la base de datos: {e}")
    finally:
        cursor.close()


def main():
    connection = connect_to_database()
    email = "jalexiscv@gmail.com"
    password = "123456"
    mail = email_exists(connection, email)
    if mail is False:
        print(f"El email no existia: {mail}")
        mail = uniqid()
        profile = uniqid()
        current_time = datetime.now()
        query = """INSERT INTO `c4isr_mails` (`mail`, `profile`, `email`, `author`, `created_at`, `updated_at`, `deleted_at`) VALUES (%s, %s, %s, %s, %s, %s, %s)"""
        tuple = (mail, profile, email, "0", current_time, None, None)
        insert_into_table(connection, query, tuple)
    else:
        print(f"El email ya existia: {mail}")

    connection.close()


if __name__ == '__main__':
    main()
