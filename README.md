# 🎓 Hall Ticket Generation System

A **web-based application** designed to automate and simplify the hall ticket generation process for educational institutions. This system streamlines the manual workload by allowing students to request hall tickets and download them once approved, while administrators can review, manage, and approve student requests through an intuitive dashboard.

---

## 🔧 Features

- 🔐 **Login Authentication** for Students and Admins
- 🧑‍🎓 **Student Dashboard**:
  - Request hall tickets by filling in exam and personal details
  - Upload a photograph
  - Track request status (Pending/Approved)
  - Download hall tickets in PDF format once approved
- 🧑‍💼 **Admin Dashboard**:
  - View all hall ticket requests
  - Approve or reject based on the submitted data
  - Ensure data integrity before hall ticket issuance
- 📝 **Dynamic Form Handling**:
  - AJAX-based fetching of supplementary subjects
  - Smooth form submission without page reload
- 📂 **PDF Hall Ticket Generation**
- 🔄 **Session Handling** for secure and seamless navigation
- 💾 **Centralized MySQL Database** for storing all user data and request states
- 📱 **Responsive Design** built with Bootstrap for all devices

---

## 🗃️ Project Structure
HALLTICKET (NEW V2)/
├── css/
│   ├── admin_dashboard.css
│   ├── login.css
│   ├── student_dashboard.css
│   ├── stylehallticket.css
│   └── submit-style.css
│
├── js/
│   └── script.js
│
├── uploads/                      # Folder to store uploaded images
│
├── admin_dashboard.php           # Admin dashboard functionality
├── approve.php                   # Script to approve hall ticket requests
├── database.php                  # MySQL database connection script
├── download_hallticket.php       # Displays approved hall ticket for download
├── download.php                  # PDF generation script (or alternate download handler)
├── hallticket-dashboard.html     # Student hall ticket request form
├── index.html                    # Login page
├── jntuacea-logo.png             # Logo used in header/footer
├── jntuacea-naac.png             # NAAC badge/logo
├── jntuacea-opacity.png          # Background watermark image
├── login.php                     # Handles login form data
├── logout.php                    # Logs out user securely
├── reject.php                    # Script to reject hall ticket requests
├── student_dashboard.php         # Dashboard for students
├── submit-hallticket.php         # Additional submission logic handler
├── submit.php                    # Fetch subjects dynamically
├── submit1.php                   # Handles hall ticket form submission

---

## 🛠️ Technologies Used

- **Frontend**: HTML, CSS, Bootstrap, JavaScript
- **Backend**: PHP
- **Database**: MySQL
- **PDF Generation**: TCPDF or DOMPDF (for rendering PDFs)
- **Others**: Fetch API / AJAX, PHP Sessions, File Upload handling

---

## ✅ How It Works

1. Users visit the `index.html` page to log in.
2. Upon successful login:
   - Admins are redirected to the admin dashboard.
   - Students are redirected to their dashboard.
3. Students can fill in a request form with their personal and academic details, and upload their photo.
4. Admins verify details and either approve or reject requests.
5. Approved students can then download their hall tickets in PDF format.

---

## 🚀 Future Enhancements

- 📧 Automated email or SMS notification system on hall ticket approval
- 🏫 Integration of exam hall allocation and seat numbers
- 🆔 QR/Barcode generation on hall tickets
- 🧾 Generate invigilator attendance sheets and reports
- 🔐 Role-based access for additional staff like faculty coordinators

---

## 📚 References

- [W3Schools – PHP & MySQL Integration](https://www.w3schools.com/php/php_mysql_intro.asp)
- [Bootstrap Documentation](https://getbootstrap.com/docs/5.0/getting-started/introduction/)
- [MDN Web Docs – Responsive Web Design](https://developer.mozilla.org/en-US/docs/Learn/CSS/CSS_layout/Responsive_Design)
- [PHP.net – File Upload Handling](https://www.php.net/manual/en/features.file-upload.php)
- [GeeksforGeeks – PHP Session Management](https://www.geeksforgeeks.org/php-session-management/)
- [TCPDF – PDF Generator](https://tcpdf.org/)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [Fetch API – MDN Docs](https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API)

---

## 👨‍💻 Developed By

**[Mude Kiran Kumar Naik]**  
[JNTUA College of Engineering, Ananthapuramu] 

---

## 📸 Screenshots (Optional)

![Screenshot 2025-04-18 120226](https://github.com/user-attachments/assets/55c84166-6480-4234-b861-19cf84d50810)


---

## 📌 License

This project is for educational purposes only. You are free to modify and use it for learning, college submissions, or academic demonstration.
