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
            apiInfoDiv.innerHTML = "<p>Explanation for API Option 1.</p>" + "<p><strong>Headers:</strong><br>Authorization: Bearer your_token<br>Content-Type: application/json</p>";
            apiLinkBtn.innerHTML = '<a href="https://api1.example.com" target="_blank">Visit API</a>';
            apiLinkBtn.disabled = false;
            break;
        case "api2":
            apiInfoDiv.innerHTML = "<p>Explanation for API Option 2.</p>" + "<p><strong>Headers:</strong><br>ApiKey: your_api_key<br>Content-Type: application/xml</p>";
            apiLinkBtn.innerHTML = '<a href="https://api2.example.com" target="_blank">Visit API</a>';
            apiLinkBtn.disabled = false;
            break;
        case "api3":
            apiInfoDiv.innerHTML = "<p>Explanation for API Option 3.</p>" + "<p><strong>Headers:</strong><br>Token: your_token<br>Content-Type: application/x-www-form-urlencoded</p>";
            apiLinkBtn.innerHTML = '<a href="https://api3.example.com" target="_blank">Visit API</a>';
            apiLinkBtn.disabled = false;
            break;
        default:
            apiInfoDiv.innerHTML = "<p>Select an API to see more information.</p>";
            apiLinkBtn.innerHTML = "Visit API";
            apiLinkBtn.disabled = true;
            break;
    }
}
