function displayApiInfo() {
    var select = document.getElementById("apiSelect");
    var selectedOption = select.options[select.selectedIndex].value;
    var apiInfoDiv = document.getElementById("apiInfo");
    var apiLinkBtn = document.getElementById("apiLinkBtn");
    apiInfoDiv.innerHTML = "";

    switch (selectedOption) {
        // Islamic
        case "hijr":
            apiInfoDiv.innerHTML = "<p>API to get the current Hijri date.</p>" + "<p><strong>Headers:</strong><br>COMMAND - Optional, use if you want the API to be called on command.</p>";
            apiLinkBtn.disabled = false;
            break;
        case "sholat":
            apiInfoDiv.innerHTML = "<p>API to get prayer schedules now.</p>" + "<p><strong>Headers:</strong><br>COMMAND - Optional, use if you want the API to be called on command.</p>";
            apiLinkBtn.disabled = false;
            break;

        // Random Text
        case "bucin":
            apiInfoDiv.innerHTML = "<p>API to get text Bucin randomly.</p>" + "<p><strong>Headers:</strong><br>There isn't any.</p>";
            apiLinkBtn.disabled = false;
            break;
        case "dare":
            apiInfoDiv.innerHTML = "<p>API to get text Dare randomly.</p>" + "<p><strong>Headers:</strong><br>There isn't any.</p>";
            apiLinkBtn.disabled = false;
            break;
        case "hacker":
            apiInfoDiv.innerHTML = "<p>API to get text Hacker randomly.</p>" + "<p><strong>Headers:</strong><br>There isn't any.</p>";
            apiLinkBtn.disabled = false;
            break;
        case "pantun":
            apiInfoDiv.innerHTML = "<p>API to get text Pantun randomly.</p>" + "<p><strong>Headers:</strong><br>There isn't any.</p>";
            apiLinkBtn.disabled = false;
            break;
        case "quotes":
            apiInfoDiv.innerHTML = "<p>API to get text Quotes randomly.</p>" + "<p><strong>Headers:</strong><br>There isn't any.</p>";
            apiLinkBtn.disabled = false;
            break;
        case "truth":
            apiInfoDiv.innerHTML = "<p>API to get text Truth randomly.</p>" + "<p><strong>Headers:</strong><br>There isn't any.</p>";
            apiLinkBtn.disabled = false;
            break;

        // Tools
        case "chatgpt":
            apiInfoDiv.innerHTML = "<p>API to get responses from ChatGPT for free.</p>" + "<p><strong>Headers:</strong><br>COMMAND - Optional, use if you want the API to be called on command.</p>";
            apiLinkBtn.disabled = false;
            break;
        case "simsimi":
            apiInfoDiv.innerHTML =
                "<p>API to get a response from Simsimi.</p>" +
                "<p><strong>Headers:</strong><br>COMMAND - Optional, use if you want the API to be called on command.<br>LANGUAGE - Must, available languages: vi, en, ph, zh, ch, ru, id, ko, ar, fr, jp, de, etc.<br>APIKEY - Optional, if you have the Simsimi API key, you can use it, if you don't have it, it's okay, everything will work normally.</p>";
            apiLinkBtn.disabled = false;
            break;
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
        // Islamic
        case "hijr":
            window.open("api/hijr.php", "_blank");
            break;
        case "sholat":
            window.open("api/sholat.php", "_blank");
            break;

        // Random Text
        case "bucin":
            window.open("api/bucin.php", "_blank");
            break;
        case "dare":
            window.open("api/dare.php", "_blank");
            break;
        case "hacker":
            window.open("api/hacker.php", "_blank");
            break;
        case "pantun":
            window.open("api/pantun.php", "_blank");
            break;
        case "quotes":
            window.open("api/quotes.php", "_blank");
            break;
        case "truth":
            window.open("api/truth.php", "_blank");
            break;

        // Tools
        case "chatgpt":
            window.open("api/chatgpt.php", "_blank");
            break;
        case "simsimi":
            window.open("api/simsimi.php", "_blank");
            break;
        default:
            break;
    }
}

function visitCredits(type) {
    let url;

    switch (type) {
        case "ai-tools":
            url = "https://ai-tools.replit.app";
            break;
        case "bohr.io":
            url = "https://bohr.io/";
            break;
        case "AutoResponderAI_ID":
            url = "https://t.me/AutoResponderAI_ID";
            break;
        case "myquran":
            url = "https://bit.ly/API-myQuran-v2";
            break;
        default:
            return;
    }

    window.open(url, "_blank");
}

function visitDonate(type) {
    let url;

    switch (type) {
        case "saweria":
            url = "https://saweria.co/itsreimau";
            break;
        case "trakteer":
            url = "https://trakteer.id/itsreimau";
            break;
        default:
            return;
    }

    window.open(url, "_blank");
}