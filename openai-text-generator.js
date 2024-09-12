document.getElementById("generate-button").addEventListener("click", function(e) {
    e.preventDefault();
    
    var generateButton = document.getElementById("generate-button");
    
    if (generateButton.disabled) {
        return; // Prevent multiple clicks while content is being generated
    }
    
    generateButton.disabled = true;
    var errorMessage = document.getElementById('error-message');
    errorMessage.style.display = 'none';

    var topic = document.getElementById('topic').value;
    var prompt = "Generate a 3 sentence story about " + topic;
    var loading = document.getElementById('loading');
    var result = document.getElementById('result');
    var resultC = document.getElementById('result-container');
    
    loading.style.display = 'block';
    result.style.display = 'none';
    resultC.style.display = 'none';

    var formData = new FormData();
    formData.append('action', 'openai_generate_text');
    formData.append('prompt', prompt);

    fetch(ajaxurl, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        loading.style.display = 'none';
        if (data.success && data.data.choices && data.data.choices[0].message.content) {
            // Show the result
            result.value = data.data.choices[0].message.content; 
            result.style.display = 'block';
            resultC.style.display = 'block';
        } else {
            errorMessage.textContent = 'An error occurred: ' + (data.data || 'Invalid response structure.');
            errorMessage.style.display = 'block';
        }
        generateButton.disabled = false;
    })
    .catch(error => {
        loading.style.display = 'none';
        errorMessage.textContent = 'An error occurred: ' + error.message;
        errorMessage.style.display = 'block';
        generateButton.disabled = false;
    });
});
