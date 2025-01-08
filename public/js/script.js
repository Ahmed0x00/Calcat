function Route(name) {
    window.location.href = name;
}

function Activate() {
    document.querySelector(".dropdown div").focus();
    console.log(document.querySelector(".dropdown div"));
}

$(document).ready(function () {
    $("#toggleBtn").click(function (event) {
        $("#Nav, #overlay3").toggleClass("show");
        event.stopPropagation(); // Prevent this click from bubbling up
    });

    $(document).click(function (event) {
        if (!$(event.target).closest("#Nav, #toggleBtn").length) {
            $("#Nav, #overlay3").removeClass("show");
        }
    });
});

// Function to load language file and set content
function setLanguage(lang) {
    const enButton = document.getElementById("en-btn");
    const arButton = document.getElementById("ar-btn");

    if (enButton && arButton) {
        if (lang === 'en') {
            arButton.classList.add("active");
            enButton.classList.remove("active");
        } else if (lang === 'ar') {
            enButton.classList.add("active");
            arButton.classList.remove("active");
        }
    }

    fetch(`langs/${lang}.json`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Failed to load language file: ${response.statusText}`);
            }
            return response.json();
        })
        .then(content => {
            localStorage.setItem("language", lang);
            Object.entries(content).forEach(([key, value]) => {
                const element = document.getElementById(key);
                if (element) {
                    if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                        element.setAttribute('placeholder', value);
                    } else if (element.tagName === 'SELECT') {
                        const options = element.querySelectorAll('option');
                        options.forEach(option => {
                            const optionKey = `${option.id}Text`;
                            if (content[optionKey]) {
                                option.innerHTML = content[optionKey];
                            }
                        });
                    } else {
                        element.innerHTML = value;
                    }
                }
            });
        })
        .catch(error => {
            console.error(`Error setting language: ${error.message}`);
        });
}

// Automatically call setLanguage when the page loads
window.onload = function () {
    const savedLanguage = localStorage.getItem("language") || "en"; // Default to 'en' if not set
    setLanguage(savedLanguage);
};


function togglePasswordVisibility() {
    const passwordField = document.getElementById("password");
    const toggleIcon = document.getElementById("passwordToggle");

    if (passwordField.type === "password") {
        passwordField.type = "text";
        toggleIcon.classList.replace("fa-eye-slash", "fa-eye");
        toggleIcon.style.color = "gray";
    } else {
        passwordField.type = "password";
        toggleIcon.classList.replace("fa-eye", "fa-eye-slash");
        toggleIcon.style.color = "gray";
    }
}

function toggleConfirmPasswordVisibility() {
    const confirmPasswordField = document.getElementById('confirm_password');
    const toggleConfirmIcon = document.getElementById('confirmPasswordToggle');

    if (confirmPasswordField.type === 'password') {
        confirmPasswordField.type = 'text';
        toggleConfirmIcon.classList.replace('fa-eye-slash', 'fa-eye');
        toggleConfirmIcon.style.color = 'gray'; 
    } else {
        confirmPasswordField.type = 'password';
        toggleConfirmIcon.classList.replace('fa-eye', 'fa-eye-slash');
        toggleConfirmIcon.style.color = 'gray'; 
    }
}


function displayAlert(message, type) {
    const openModal = document.querySelector('.modal.show .modal-content');
    const alertContainer = openModal || document.getElementById("alertContainer");
    
    const alertElement = document.createElement("div");
    alertElement.className = `alert alert-${type} alert-dismissible fade show`;
    alertElement.role = "alert";

    if (openModal) {
        alertElement.style.cssText = `
            z-index: 1050;
            position: absolute;
            top: 10;
            width: 120%;
        `;
    } else {
        alertElement.style.cssText = `
            margin: 10px auto; /* Center and reduce width */
            width: 70%; /* Smaller width when outside modal */
        `;
    }
    
    alertElement.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;

    alertContainer.appendChild(alertElement);

    setTimeout(() => {
        alertElement.classList.remove("show");
        alertElement.addEventListener("transitionend", () => alertElement.remove());
    }, 2000);
}



function logout() {
    fetch('/logout', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.message === "Successfully logged out") {
            displayAlert("Logout successful! Redirecting to login page...", "success");
            setTimeout(() => {
                window.location.href = "/login"; // Redirect to login page
            }, 1000);
        } else if (data.message) {
            displayAlert(data.message, "danger"); // Display error message
        }
    })
    .catch(error => {
        console.error('Error:', error);
        displayAlert('An error occurred while logging out.', "danger");
    });
}
