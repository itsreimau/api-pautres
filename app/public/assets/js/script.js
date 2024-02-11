function displayApiInfo() {
    var select = document.getElementById("apiSelect");
    var selectedOption = select.options[select.selectedIndex].value;
    var apiInfoDiv = document.getElementById("apiInfo");
    var apiLinkBtn = document.getElementById("apiLinkBtn");

    // Clear previous content
    apiInfoDiv.innerHTML = "";

    // Display different information based on the selected API
    switch (selectedOption) {
        case "api1":
            apiInfoDiv.innerHTML = "<p>API to get responses from ChatGPT for free.</p>" + "<p><strong>Headers:</strong><br>COMMAND</p>";
            apiLinkBtn.innerHTML = '<a href="api/chatgpt.php" target="_blank">Visit API</a>';
            apiLinkBtn.disabled = false;
            break;
        case "api2":
            apiInfoDiv.innerHTML = "<p>API to get a response from Simsimi.</p>" + "<p><strong>Headers:</strong><br>COMMAND - Optional, use if you want the API to be called on command.<br>LANGUAGE - Must, available languages: vi, en, ph, zh, ch, ru, id, ko, ar, fr, james, de, etc.<br>APIKEY - Optional, if you have the Simsimi API key, you can use it, if you don't have it, it's okay, everything will work normally.</p>";
            apiLinkBtn.innerHTML = '<a href="api/simsimi.php" target="_blank">Visit API</a>';
            apiLinkBtn.disabled = false;
            break;
        default:
            apiInfoDiv.innerHTML = "<p>Select an API to see more information.</p>";
            apiLinkBtn.innerHTML = "Visit API";
            apiLinkBtn.disabled = true;
            break;
    }
}
