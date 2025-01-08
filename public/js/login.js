document.getElementById('LoginButton').addEventListener('click', function(e) {
    e.preventDefault();

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    // Prepare the data to be sent
    const data = {
        email: email,
        password: password
    };

    // Send the login request
    fetch('/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if (data.message === "Login successful") {
            try {
                if (data.user.company_id === null) {
                    window.location.href = "/";
                } else {
                    // Attempt to save the company_id to localStorage for regular users
                    localStorage.setItem('company_id', data.user.company_id);

                    // Verify that the company_id is successfully stored
                    if (localStorage.getItem('company_id') === data.user.company_id) {
                        displayAlert("Login successful! Redirecting to dashboard...", "success");
                        setTimeout(() => {
                            window.location.href = "home"; // Redirect to user dashboard page
                        }, 800);
                    } else {
                        throw new Error('Unable to store company_id in localStorage.');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                displayAlert('An error occurred while processing your login. Please try again.', "danger");
            }
        } else if (data.message) {
            displayAlert(data.message, "danger"); // Display error message
        }
    })
    .catch(error => {
        console.error('Error:', error);
        displayAlert('An error occurred while logging in.', "danger");
    });
});