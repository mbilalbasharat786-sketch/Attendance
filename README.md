# 🎓 Attendance Management System (Enterprise Edition)

A robust, enterprise-grade Attendance and Task Management System built with Laravel. This application provides a seamless portal for students to mark attendance, submit leave requests, and manage assignments, while giving administrators full control over user management, grading, task reviews, and detailed reporting.

---

## 🌐 Live Demo & Credentials

- **Public / User Portal:** [https://attendance.free.laravel.cloud/](https://attendance.free.laravel.cloud/)
- **Admin Portal:** [https://attendance.free.laravel.cloud/dashboard/admin](https://attendance.free.laravel.cloud/dashboard/admin) *(or `/admin`)*

**Super Admin Credentials:**
- **Email:** `officialbilal707@gmail.com`
- **Password:** `admin123`

---

## 🛠️ Tech Stack & UI Design

- **Backend Framework:** Laravel 11.x (PHP)
- **Database:** SQLite (Configured for Cloud Deployment)
- **Frontend Styling:** Tailwind CSS (Compiled via Vite for a premium, custom enterprise UI)
- **Icons:** FontAwesome 6.4.0 (via CDN)
- **Rich Text Editor:** CKEditor (For rich-text task assignments)
- **Role Management:** Spatie Laravel-Permission
- **Hosting / Deployment:** Laravel Cloud

> **UI Theme Note:** The entire application features a "Premium Corporate/Enterprise" theme with floating shadow cards, soft slate/indigo color palettes, interactive hover states, and smooth transitions built purely with Tailwind CSS utility classes.

---

## ✅ User Panel Features

1. **Authentication**
   - Premium Registration, Login, Forgot Password, and Verify Email pages.
2. **Interactive Dashboard**
   - **Mark Attendance:** One-click attendance tracking. Users are restricted to marking attendance only once per day (preventing duplicates or deletions).
   - **Mark Leave:** Dedicated portal to submit leave requests.
   - **View Attendance:** Real-time summary of daily records.
3. **Profile Management**
   - Users can securely upload and crop their profile pictures. Files are managed via Laravel's local `public` storage disk.
4. **Leave Requests**
   - Users can request leaves for specific dates with reasons and track their live status (Pending, Approved, Rejected).

---

## 🛡️ Admin Panel Features

1. **Secure Admin Authentication**
   - Isolated login routes specifically for administrative access.
2. **Student Management**
   - Comprehensive DataGrid to view all registered users. Admin can manually Add, Edit, or Delete attendance records and view individual summaries.
3. **Leave Approval Module**
   - Centralized hub to view, review, and Approve/Reject leaves with custom feedback comments. Tracks total leave counts per student.
4. **Advanced Attendance Reports**
   - **Per Student:** Filter by specific user and date ranges for deep-dive reports.
   - **System-Wide:** Generate overarching attendance summaries between selected dates.
5. **Automated Grading System**
   - Grades are calculated dynamically on the fly based on attendance counts:
     - `Grade A`: 26+ Days Present
     - `Grade B`: 20-25 Days Present
     - `Grade C`: 15-19 Days Present
     - `Grade D`: 10-14 Days Present
     - `Grade F`: < 10 Days
6. **Task Management Module**
   - **Creation:** Admins assign tasks utilizing **CKEditor** for rich-text formatting.
   - **Submission & Review:** Students complete tasks via their portal. Admins can review submissions, mark them as Approved/Rejected, and provide feedback.
7. **Roles & Permissions (Spatie)**
   - Dynamic Role Management UI. Admins can create custom roles (e.g., Teacher, HR) and assign granular permissions. Roles can be assigned to students directly from the Student Management table.
8. **Automated Email Notifications**
   - Fully integrated SMTP Mailers trigger automatic emails for critical events:
     - Upon marking attendance.
     - When a leave request is submitted.
     - When tasks are assigned, approved, or rejected.

---

## ⚙️ Environment Configuration (.env)

To run the Email Notification system, the following variables must be configured in your `.env` file using a valid SMTP provider (e.g., Gmail App Passwords):

```env
MAIL_MAILER=smtp
MAIL_HOST=********
MAIL_PORT=******
MAIL_USERNAME="************"
MAIL_PASSWORD="*************"
MAIL_ENCRYPTION=******
MAIL_FROM_ADDRESS="************"
MAIL_FROM_NAME="${APP_NAME}"

# Required for Profile Pictures to display correctly
FILESYSTEM_DISK=public
APP_URL=[https://attendance.free.laravel.cloud](https://attendance.free.laravel.cloud)