export function Crypt() {

// Actualización de la estructura de crypto para incluir una función de generación de clave
    const crypto = {
        alphabet: 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789',
        generateKey(length) {
            let result = '';
            let charactersLength = crypto.alphabet.length;
            for (let i = 0; i < length; i++) {
                result += crypto.alphabet.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        }
    };

    function Encrypt(text, keyLength = 16) {
        const key = crypto.generateKey(keyLength);
        let result = key; // Iniciamos el resultado con la clave
        for (let i = 0; i < text.length; i++) {
            let charIndex = crypto.alphabet.indexOf(text[i]);
            if (charIndex !== -1) {
                let newIndex = (charIndex + crypto.alphabet.indexOf(key[i % keyLength])) % crypto.alphabet.length;
                result += crypto.alphabet[newIndex];
            } else {
                result += text[i]; // Caracteres especiales no se encriptan
            }
        }
        return result;
    }

    function Decrypt(encryptedText, keyLength = 16) {
        const key = encryptedText.substring(0, keyLength); // Extraemos la clave
        let text = encryptedText.substring(keyLength); // Extraemos el mensaje encriptado sin la clave
        let result = '';
        for (let i = 0; i < text.length; i++) {
            let charIndex = crypto.alphabet.indexOf(text[i]);
            if (charIndex !== -1) {
                let newIndex = (charIndex - crypto.alphabet.indexOf(key[i % keyLength]) + crypto.alphabet.length) % crypto.alphabet.length;
                result += crypto.alphabet[newIndex];
            } else {
                result += text[i]; // Caracteres especiales no se desencriptan
            }
        }
        return result;
    }

    function Exec(timestamp) {
        console.log('Crypt Executed at: ' + timestamp);
    }


    return {
        Encrypt: Encrypt,
        Decrypt: Decrypt,
        Exec: Exec,
    };
}