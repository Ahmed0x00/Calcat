 // Function to format the number with commas
 function formatNumberWithCommas(value) {
    const number = parseFloat(value.replace(/,/g, ''));
    return isNaN(number) ? '' : number.toLocaleString('en-US');
}

// Event listener for the balance input
document.getElementById('balance').addEventListener('input', function (e) {
    // Remove all non-digit characters (except dot for decimals)
    const rawValue = e.target.value.replace(/[^0-9.]/g, '');

    // Format the cleaned number
    const formattedValue = formatNumberWithCommas(rawValue);
    
    // Update the input value with the formatted number
    e.target.value = formattedValue;
});

document.getElementById('RegisterButton').addEventListener('click', function (e) {
    e.preventDefault();

    const name = document.getElementById('name').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    const balance = document.getElementById('balance').value.replace(/,/g, ''); // Remove commas for processing
    const licenseKey = document.getElementById('license_key').value; // Get license key

    // Check if passwords match
    if (password !== confirmPassword) {
        displayAlert("Passwords do not match!", "danger");
        return;
    }

    // Prepare the data to be sent
    const data = {
        name: name,
        email: email,
        password: password,
        password_confirmation: confirmPassword,
        balance: parseFloat(balance) || 0, // Convert balance to a float and default to 0 if empty
        license_key: licenseKey // Include license key
    };

    // Send the registration request to the correct API endpoint
    fetch('/register', {  // Or update to '/api/register' if you're using an API route
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.message === "Registration successful") {
            displayAlert("Registration successful! Redirecting to login...", "success");
            setTimeout(() => {
                window.location.href = "/login"; // Redirect to login page
            }, 2000);
        } else if (data.message) {
            displayAlert(data.message, "danger"); // Display error message from backend
        } else {
            displayAlert('An unknown error occurred.', "danger"); // Handle unexpected cases
        }
    })
    .catch(error => {
        console.error('Error:', error);
        displayAlert('An error occurred while registering.', "danger");
    });
});