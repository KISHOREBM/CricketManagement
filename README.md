# 🏏 Cricket Management System

This is a dynamic web-based application designed to manage and display cricket-related information such as player statistics, team data, ground details, and past match records. Built using PHP and MySQL for backend and HTML/CSS/JavaScript for frontend, the system is ideal for organizing, presenting, and analyzing cricket data for players, administrators, and viewers.

---

## 🎯 Features

- 🔐 **User Authentication** – Login and registration functionality for users and administrators.
- 🧑‍🤝‍🧑 **Team Management** – Add, edit, and fetch teams using dynamic forms and backend APIs.
- 🏏 **Player Stats** – View individual player profiles with detailed statistics.
- 🗓️ **Match Records** – Display information about past cricket matches.
- 🏟️ **Ground Info** – Ground details with images and descriptions.
- 📄 **Form Generation** – Admin utilities for generating and selecting data entry forms.
- 📞 **Contact and About Pages** – Informational static pages to support users.

---

## 🧱 Tech Stack

- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP
- **Database**: MySQL
- **Styling**: Custom CSS (`sty.css`, `styli.css`, `player (1).css`)
- **Media**: JPG, JPEG, WEBP images for UI and cricket content

---

## 🗂️ Project Structure

| File/Folder               | Description                                      |
|---------------------------|--------------------------------------------------|
| `index.html`              | Landing page                                     |
| `login.php`               | Login backend handling                           |
| `register1.html/.php`     | User registration form and backend               |
| `admin.php`               | Admin dashboard / panel                          |
| `player.html/.php`        | Display player stats and details                 |
| `ground.php`              | Information about cricket grounds                |
| `fetch_teams.php`         | PHP script to retrieve team data (AJAX)          |
| `fetch_team_details.php`  | PHP script for fetching detailed team info       |
| `form_generator.php`      | Script to generate input forms                   |
| `form_selector.php`       | Interface to select available forms              |
| `About.html`              | About page                                       |
| `contact.html`            | Contact info                                     |
| `*.css`                   | Stylesheets                                      |
| `*.jpg / *.webp / *.jpeg` | Media/images used throughout the application     |

---

## 🛠️ How to Set Up

### 🖥️ Local Development (XAMPP or similar)

1. Clone or download the repository to your server root directory (e.g., `htdocs` in XAMPP).
2. Start **Apache** and **MySQL** from the XAMPP control panel.
3. Import the provided SQL dump file into **phpMyAdmin**:
   - Visit `http://localhost/phpmyadmin`
   - Create a new database (e.g., `cricketdb`)
   - Import the SQL file
4. Update the DB credentials in PHP files if needed (`username`, `password`, `dbname`).
5. Visit the app at:
   ```
   http://localhost/cricket/index.html
   ```

---

## 🔓 Admin Panel

Access the admin features via:

```
admin.php
```

Admin capabilities include:
- Managing players and teams
- Generating custom forms
- Viewing ground and match info

---



## ✅ Example Pages

| Page            | Description                     |
|-----------------|---------------------------------|
| `signin.html`   | User login page                 |
| `player.html`   | Player profiles and stats       |
| `ground.php`    | Details about cricket grounds   |
| `test.html`     | Test or demo HTML page          |
| `web.html`      | Generic HTML content page       |

---

## 📌 Future Enhancements

- Add match scheduling and live scoring
- Integrate with external cricket APIs
- Add search/filter for players and teams
- Responsive design improvements

---

## 📃 License

This project is for **educational purposes**. Feel free to modify and build upon it for learning or internal use.

---

## 🙌 Acknowledgments

- PHP & MySQL Documentation
- Open-source CSS frameworks
- Cricket enthusiasts and the development community!

---

