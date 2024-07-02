function atbashCipher(inputText, action) {
    const alphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    const reverseAlphabet = "ZYXWVUTSRQPONMLKJIHGFEDCBA";

    let result = "";

    for (let i = 0; i < inputText.length; i++) {
        const char = inputText.charAt(i).toUpperCase();

        if (alphabet.includes(char)) {
            const index = alphabet.indexOf(char);

            if (action === "encrypt") {
                result += reverseAlphabet.charAt(index);
            } else {
                result += alphabet.charAt(index);
            }
        } else {
            result += char;
        }
    }

    return result;
}

function performAction() {
    const inputText = document.getElementById("inputText").value;
    const cipherSelect = document.getElementById("cipherSelect").value;

    let result = "";

    if (cipherSelect === "encrypt") {
        result = atbashCipher(inputText, "encrypt");
    } else {
        result = atbashCipher(inputText, "decrypt");
    }

    document.getElementById("outputText").value = result;
}