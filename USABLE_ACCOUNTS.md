# CKC SHRMS - Usable Accounts Summary

## Test Accounts Created

### Admin Account
- **Email:** admin@ckc.edu
- **Password:** password123
- **Name:** Admin User
- **Type:** Admin (user_type: 2)
- **Table:** admins

### Doctor Account
- **Email:** doctor@ckc.edu  
- **Password:** password123
- **Name:** Dr. John Smith
- **Type:** Doctor (user_type: 3)
- **Table:** users

### Staff Account
- **Email:** staff@ckc.edu
- **Password:** password123
- **Name:** Jane Staff
- **Type:** Staff (user_type: 2)
- **Table:** users

### Student Account
- **Email:** student@ckc.edu
- **Password:** password123
- **Name:** John Student
- **Type:** Student (user_type: 1)
- **Table:** users

## Additional Random Users
- **Oral Immanuel Greenfelder** (natasha20@example.com) - Doctor (Type 3)
- **Art Eloy Dooley** (ernestine01@example.org) - Staff (Type 2)
- **Anahi Trinity Gislason** (dolores.schmidt@example.com) - Student (Type 1)

## User Type Mapping
- **1 = Student**
- **2 = Faculty & Staff**
- **3 = Doctor**

## Login Instructions
1. Visit: http://127.0.0.1:8000
2. Use any of the email addresses above
3. Password for all test accounts: **password123**
4. Password for random users: **password**

## Features by User Type

### Doctor (user_type = 3)
- Dashboard with medical statistics
- Health Records management
- Medications management
- Patient management
- Appointment scheduling

### Staff (user_type = 2)
- Administrative dashboard
- Staff management features

### Student (user_type = 1)
- Student portal
- Personal records

### Admin
- Full system administration
- User management
- System settings
