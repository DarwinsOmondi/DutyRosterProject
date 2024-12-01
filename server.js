
const express = require('express');
const mysql = require('mysql');
const bodyParser = require('body-parser');
const app = express();


app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));


const db = mysql.createConnection({
    host: 'localhost',     
    user: 'root',          
    password: '',          
    database: 'dutyroster' 
});

// Connect to the database
db.connect(err => {
    if (err) throw err;
    console.log('MySQL connected...');
});

// POST request to handle login
app.post('/login', (req, res) => {
    const { username, password, role } = req.body;

    const query = 'SELECT * FROM users WHERE username = ? AND password = ? AND role = ?';
    db.query(query, [username, password, role], (err, result) => {
        if (err) throw err;

        if (result.length > 0) {
            res.send({ success: true, message: `Logged in as ${role}` });
        } else {
            res.send({ success: false, message: 'Invalid credentials' });
        }
    });
});

// POST request to handle signup
app.post('/signup', (req, res) => {
    const { username, password, role } = req.body;

    const query = 'INSERT INTO users (username, password, role) VALUES (?, ?, ?)';
    db.query(query, [username, password, role], (err, result) => {
        if (err) throw err;

        res.send({ success: true, message: 'User registered successfully' });
    });
});

// POST request to handle duty assignment
app.post('/assignDuty', (req, res) => {
    const { janitor_name, duty_day, shift_time, duty_details } = req.body;

    const query = 'INSERT INTO duties (janitor_id, duty_day, shift_time, duty_details) VALUES ((SELECT id FROM users WHERE username = ?), ?, ?, ?)';
    db.query(query, [janitor_name, duty_day, shift_time, duty_details], (err, result) => {
        if (err) throw err;

        res.send({ success: true, message: 'Duty assigned successfully' });
    });
});

// Start server
app.listen(3000, () => {
    console.log('Server started on http://localhost:3000');
});
