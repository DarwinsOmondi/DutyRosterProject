let users = [
    {username: 'manager1', password: 'pass123', role: 'manager'},
    {username: 'janitor1', password: 'pass123', role: 'janitor'}
];

let duties = []; 

function login() {
    let username = document.getElementById('username').value;
    let password = document.getElementById('password').value;
    let role = document.getElementById('role').value;

    let user = users.find(user => user.username === username && user.password === password && user.role === role);

    if (user) {
        alert("Login successful!");
        document.getElementById('login-section').style.display = 'none';
        if (role === 'manager') {
            document.getElementById('manager-dashboard').style.display = 'block';
            displayDuties();
        } else if (role === 'janitor') {
            document.getElementById('janitor-dashboard').style.display = 'block';
            displayJanitorDuties(username);
        }
    } else {
        alert("Invalid login credentials!");
    }
}

function signup() {
    let username = document.getElementById('new-username').value;
    let password = document.getElementById('new-password').value;
    let role = document.getElementById('new-role').value;

    users.push({username: username, password: password, role: role});
    alert("Signup successful! You can now log in.");
    showLogin();
}

function showSignup() {
    document.getElementById('login-section').style.display = 'none';
    document.getElementById('signup-section').style.display = 'block';
}

function showLogin() {
    document.getElementById('signup-section').style.display = 'none';
    document.getElementById('login-section').style.display = 'block';
    document.getElementById('forgot-password-section').style.display = 'none';
}

function assignDuty() {
    let janitorName = document.getElementById('janitor-name').value;
    let day = document.getElementById('duty-day').value;
    let startTime = document.getElementById('duty-start-time').value;
    let endTime = document.getElementById('duty-end-time').value;
    let duty = document.getElementById('duty-details').value;

    if (janitorName && day && startTime && endTime && duty) {
        duties.push({
            janitor: janitorName,
            day: day,
            startTime: startTime,
            endTime: endTime,
            duty: duty
        });
        alert("Duty assigned successfully!");
        displayDuties();
    } else {
        alert("Please fill out all fields.");
    }
}

function displayDuties() {
    let assignedDutiesDiv = document.getElementById('assigned-duties');
    assignedDutiesDiv.innerHTML = '';

    if (duties.length === 0) {
        assignedDutiesDiv.innerHTML = "No duties assigned.";
    } else {
        let table = `<table>
                        <tr>
                            <th>Janitor</th>
                            <th>Day</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Duty</th>
                        </tr>`;
        duties.forEach(duty => {
            table += `<tr>
                        <td>${duty.janitor}</td>
                        <td>${duty.day}</td>
                        <td>${duty.startTime}</td>
                        <td>${duty.endTime}</td>
                        <td>${duty.duty}</td>
                      </tr>`;
        });
        table += '</table>';
        assignedDutiesDiv.innerHTML = table;
    }
}

function displayJanitorDuties(username) {
    let janitorDutiesDiv = document.getElementById('janitor-duties');
    janitorDutiesDiv.innerHTML = '';

    let janitorDuties = duties.filter(duty => duty.janitor === username);
    
    if (janitorDuties.length === 0) {
        janitorDutiesDiv.innerHTML = "No duties assigned.";
    } else {
        let table = `<table>
                        <tr>
                            <th>Day</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Duty</th>
                        </tr>`;
        janitorDuties.forEach(duty => {
            table += `<tr>
                        <td>${duty.day}</td>
                        <td>${duty.startTime}</td>
                        <td>${duty.endTime}</td>
                        <td>${duty.duty}</td>
                      </tr>`;
        });
        table += '</table>';
        janitorDutiesDiv.innerHTML = table;
    }
}

function logout() {
    document.getElementById('manager-dashboard').style.display = 'none';
    document.getElementById('janitor-dashboard').style.display = 'none';
    document.getElementById('login-section').style.display = 'block';
}

// New Functions for Forgot Password

function showForgotPassword() {
    document.getElementById('login-section').style.display = 'none';
    document.getElementById('forgot-password-section').style.display = 'block';
}

function resetPassword() {
    let username = document.getElementById('forgot-username').value;
    let newPassword = document.getElementById('forgot-new-password').value;

    let user = users.find(user => user.username === username);

    if (user) {
        user.password = newPassword;
        alert("Password reset successful! You can now log in with your new password.");
        showLogin();
    } else {
        alert("Username not found!");
    }
}
