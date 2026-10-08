<h1>KayaGov</h1>

KayaGov is a community-driven platform designed to help citizens report local concerns, allow government offices to manage and resolve those concerns, and provide administrators with tools for monitoring and content moderation.

The platform connects Citizens, Government users, and Administrators in one system where community concerns can be submitted, prioritized, managed, and resolved.

---

## Tech Stack Used

- PHP
- Laravel
- MySQL
- JavaScript
- HTML
- CSS
- Bootstrap

---

<h3>User Roles</h3>

KayaGov supports three types of users:

- Citizen
    - Submit concerns
    - View concerns
    - Prioritize concerns
    - Comment on concerns
    - Track submitted concerns
    - View resolved concerns
- Government
    - View concerns within their assigned city
    - Accept concerns for processing
    - Comment on concerns
    - Mark concerns as resolved
    - Track pending and resolved concerns
- Admin
    - Manage users
    - Monitor concerns
    - Moderate reported content
    - Delete inappropriate concerns
    - View system statistics
    - View citizen and government feedback about the application

---

<h2>Authentication</h2>
<h3>Login</h3>

Users can log into their KayaGov account using their registered credentials.

<h3>Logout</h3>

Authenticated users can securely log out of the website.

<h3>Sign Up</h3>

Citizens can create their own accounts.

Citizen registration should require:

- Name
- Email
- Password
- Province
- City

<h3>Admin Account Creation</h3>

Admin is able to create accounts for:

- Other Admin users
- Government users

When creating a Government account, the Admin must specify the city assigned to the government account.

Government users will only have access to concerns belonging to their assigned city.

<h3>Staff Account Creation (Government)</h3>

Staff account can be created by adding the link below in the base link:

/create/staff
