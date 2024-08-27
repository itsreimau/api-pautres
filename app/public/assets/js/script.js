function displayApiInfo() {
    var select = document.getElementById("apiSelect");
    var selectedOption = select.options[select.selectedIndex].value;
    var apiInfoDiv = document.getElementById("apiInfo");
    var apiLinkBtn = document.getElementById("apiLinkBtn");
    apiInfoDiv.innerHTML = "";

    switch (selectedOption) {
        // AI
        case "chatgpt":
            apiInfoDiv.innerHTML =
                "<p>API to get responses from ChatGPT for free.</p>" +
                '<p><strong>Headers:</strong><br>REPLIES - Optional, to send a custom replies message. Available variables: %response%.<br>API - Optional, to get a ChatGPT response from the selected API type. Available types: Akhiro, ngodingaja, nyx_gpt4, nyx_gpt, and nyx_turbo.<br>EXPERIMENTAL - Optional, for experimental use. Enter "true" to use it.</br>REGEX - Must if use EXPERIMENTAL, to combine REGEX and messages.</br>ARG1 - Must if using EXPERIMENTAL, to retrieve messages in a capture group to use as argument.</p>';
            apiLinkBtn.disabled = false;
            break;
        case "blackbox":
            apiInfoDiv.innerHTML =
                "<p>API to get responses from BlackBox for free.</p>" +
                '<p><strong>Headers:</strong><br>REPLIES - Optional, to send a custom replies message. Available variables: %response%.<br>EXPERIMENTAL - Optional, for experimental use. Enter "true" to use it.</br>REGEX - Must if use EXPERIMENTAL, to combine REGEX and messages.</br>ARG1 - Must if using EXPERIMENTAL, to retrieve messages in a capture group to use as argument.</p>';
            apiLinkBtn.disabled = false;
            break;
        case "gemini":
            apiInfoDiv.innerHTML =
                "<p>API to get responses from Gemini for free.</p>" +
                '<p><strong>Headers:</strong><br>REPLIES - Optional, to send a custom replies message. Available variables: %response%.<br>EXPERIMENTAL - Optional, for experimental use. Enter "true" to use it.</br>REGEX - Must if use EXPERIMENTAL, to combine REGEX and messages.</br>ARG1 - Must if using EXPERIMENTAL, to retrieve messages in a capture group to use as argument.</p>';
            apiLinkBtn.disabled = false;
            break;
        case "metallama":
            apiInfoDiv.innerHTML =
                "<p>API to get responses from Meta Llama for free.</p>" +
                '<p><strong>Headers:</strong><br>REPLIES - Optional, to send a custom replies message. Available variables: %response%.<br>EXPERIMENTAL - Optional, for experimental use. Enter "true" to use it.</br>REGEX - Must if use EXPERIMENTAL, to combine REGEX and messages.</br>ARG1 - Must if using EXPERIMENTAL, to retrieve messages in a capture group to use as argument.</p>';
            apiLinkBtn.disabled = false;
            break;
        case "mistral":
            apiInfoDiv.innerHTML =
                "<p>API to get responses from Mistral for free.</p>" +
                '<p><strong>Headers:</strong><br>REPLIES - Optional, to send a custom replies message. Available variables: %response%.<br>EXPERIMENTAL - Optional, for experimental use. Enter "true" to use it.</br>REGEX - Must if use EXPERIMENTAL, to combine REGEX and messages.</br>ARG1 - Must if using EXPERIMENTAL, to retrieve messages in a capture group to use as argument.</p>';
            apiLinkBtn.disabled = false;
            break;

        // Fun
        case "simsimi":
            apiInfoDiv.innerHTML =
                "<p>API to get a response from Simsimi.</p>" +
                "<p><strong>Headers:</strong><br>REPLIES - Optional, to send a custom replies message. Available variables: %response%.<br>LANGUAGE - Must, available languages: vi, en, ph, zh, ch, ru, id, ko, ar, fr, jp, de, etc.<br>APIKEY - Optional, if you have the Simsimi API key, you can use it, if you don't have it, it's okay, everything will work normally.</br>EXPERIMENTAL - Optional, for experimental use. Enter \"true\" to use it.</p>";
            apiLinkBtn.disabled = false;
            break;

        // Random Text
        case "bucin":
            apiInfoDiv.innerHTML = "<p>API to get text Bucin randomly.</p>" + "<p><strong>Headers:</strong><br>REPLIES - Optional, to send a custom replies message. Available variables: %text%.</p>";
            apiLinkBtn.disabled = false;
            break;
        case "dare":
            apiInfoDiv.innerHTML = "<p>API to get text Dare randomly.</p>" + "<p><strong>Headers:</strong><br>REPLIES - Optional, to send a custom replies message. Available variables: %text%.</p>";
            apiLinkBtn.disabled = false;
            break;
        case "hacker":
            apiInfoDiv.innerHTML = "<p>API to get text Hacker randomly.</p>" + "<p><strong>Headers:</strong><br>REPLIES - Optional, to send a custom replies message. Available variables: %text%.</p>";
            apiLinkBtn.disabled = false;
            break;
        case "pantun":
            apiInfoDiv.innerHTML = "<p>API to get text Pantun randomly.</p>" + "<p><strong>Headers:</strong><br>REPLIES - Optional, to send a custom replies message. Available variables: %text%.</p>";
            apiLinkBtn.disabled = false;
            break;
        case "quotes":
            apiInfoDiv.innerHTML = "<p>API to get text Quotes randomly.</p>" + "<p><strong>Headers:</strong><br>REPLIES - Optional, to send a custom replies message. Available variables: %text%.</p>";
            apiLinkBtn.disabled = false;
            break;
        case "truth":
            apiInfoDiv.innerHTML = "<p>API to get text Truth randomly.</p>" + "<p><strong>Headers:</strong><br>REPLIES - Optional, to send a custom replies message. Available variables: %text%.</p>";
            apiLinkBtn.disabled = false;
            break;

        // Default
        default:
            apiInfoDiv.innerHTML = "<p>Select an API to see more information.</p>";
            apiLinkBtn.disabled = true;
            break;
    }
}

function visitApi() {
    var select = document.getElementById("apiSelect");
    var selectedOption = select.options[select.selectedIndex].value;

    switch (selectedOption) {
        // AI
        case "chatgpt":
            window.open("api/ai/chatgpt.php", "_blank");
            break;
        case "blackbox":
            window.open("api/ai/blackbox.php", "_blank");
            break;
        case "gemini":
            window.open("api/ai/gemini.php", "_blank");
            break;
        case "metallama":
            window.open("api/ai/metallama.php", "_blank");
            break;
        case "mistral":
            window.open("api/ai/mistral.php", "_blank");
            break;

        // Fun
        case "simsimi":
            window.open("api/fun/simsimi.php", "_blank");
            break;

        // Random Text
        case "bucin":
            window.open("api/random-text/bucin.php", "_blank");
            break;
        case "dare":
            window.open("api/random-text/dare.php", "_blank");
            break;
        case "hacker":
            window.open("api/random-text/hacker.php", "_blank");
            break;
        case "pantun":
            window.open("api/random-text/pantun.php", "_blank");
            break;
        case "quotes":
            window.open("api/random-text/quotes.php", "_blank");
            break;
        case "truth":
            window.open("api/random-text/truth.php", "_blank");
            break;

        // Default
        default:
            break;
    }
}

function visitCredits(type) {
    let url;

    switch (type) {
        case "akhiro": // AkhiroBOT Rest APIs
            url = "https://akhiro-rest-api.onrender.com/";
            break;
        case "bohr-io": // Bohr IO
            url = "https://bohr.io/";
            break;
        case "AutoResponderAI-ID": // Komunitas AutoResponder.ai ID
            url = "https://t.me/AutoResponderAI_ID";
            break;
        case "ngodingaja": // Milfu Rest APIs
            url = "https://api.ngodingaja.my.id/";
            break;
        case "nyx": // Nyx Rest-Api
            url = "https://api.nyx.my.id/";
            break;
        case "sandipbaruwal": // OtinXSandip API
            url = "https://sandipbaruwal.onrender.com/";
            break;

        // Default
        default:
            return;
    }

    window.open(url, "_blank");
}

function visitDonate(type) {
    let url;

    switch (type) {
        case "paypal":
            url = "https://paypal.me/itsreimau";
            break;
        case "saweria":
            url = "https://saweria.co/itsreimau";
            break;
        case "trakteer":
            url = "https://trakteer.id/itsreimau";
            break;

        // Default
        default:
            return;
    }

    window.open(url, "_blank");
}