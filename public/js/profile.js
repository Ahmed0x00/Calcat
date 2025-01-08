$(document).ready(function() {
    // Fetch user data
    $.ajax({
        url: "/user",
        method: "GET",
        dataType: "json",
        success: function(data) {
            const user = data.user;

            // Populate user details
            $("#userName").text(user.name);
            $("#userEmail").text(user.email);
            $("#userRole").text(user.role);



            // Optional fields for employee-specific details
            const optionalFields = ["phone", "employee_id"];
            const iconMap = {
                phone: "fa-phone",
                employee_id: "fa-id-card",
            };

            const $optionalCards = $("#optionalCards");
            const language = localStorage.getItem("language") || "en";

            const fieldTranslations = {
                phone: language === "ar" ? "رقم الهاتف" : "PHONE",
                employee_id: language === "ar" ? "رقم هوية الموظف" : "EMPLOYEE ID",
            };

            if (user.employee_id) {
                // Create cards for optional fields if available
                optionalFields.forEach((field) => {
                    if (user[field] !== null) {
                        const iconClass = iconMap[field] || "fa-info-circle";
                        const cardHtml = `
                            <div class="col-sm-3">
                                <div class="card shadow-sm p-3 mb-5 bg-white rounded">
                                    <div class="card-body">
                                        <h5 class="card-title text-dark">
                                            <i class="fas ${iconClass} text-secondary"></i> ${fieldTranslations[field]}
                                        </h5>
                                        <p class="card-text text-secondary">${user[field]}</p>
                                    </div>
                                </div>
                            </div>
                        `;
                        $optionalCards.append(cardHtml);
                    }
                });
            }
        },
        error: function(error) {
            console.error("Error fetching user data:", error);
        }
    });

    // Handle Change Password form submission
    $("#changePasswordForm").on("submit", function(event) {
        event.preventDefault();

        const currentPassword = $("#currentPassword").val();
        const newPassword = $("#newPassword").val();
        const confirmPassword = $("#confirmPassword").val();

        // Validate if new password and confirmation match
        if (newPassword !== confirmPassword) {
            displayAlert("New password and confirmation do not match", "danger");
            return;
        }

        const csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: "/change-password",
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            contentType: "application/json",
            data: JSON.stringify({
                current_password: currentPassword,
                new_password: newPassword,
                new_password_confirmation: confirmPassword,
            }),
            success: function(data) {
                if (data.message === "Password changed successfully") {
                    displayAlert("Password changed successfully, logging out...", "success");
                    logout();
                } else {
                    $("#changePasswordModal").removeClass("show");
                    $("#changePasswordForm")[0].reset();
                    displayAlert("Password change failed. Please try again.", "danger");
                }
            },
            error: function(error) {
                console.error("Error changing password:", error);
                displayAlert("An unexpected error occurred. Please try again.", "danger");
            }
        });
    });
});
