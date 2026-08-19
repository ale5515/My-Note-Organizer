# My-Note-Organizer
A Web Application that makes our lifestyle easier!
IMPORTANT NOTE: This project MUST be hosted and executed using XAMPP Localhost (or a similar local Apache/MySQL server stack with PHP support).

---

## Technical Overview

A secure, full-stack productivity ecosystem designed to eliminate app fatigue by consolidating daily tasks, notes, and finance into a single high-performance environment. Built with PHP and MySQL, it features a modern card-based interface and advanced security safeguards.

---

## Key Features

* Daily Mastery: Priority-first workflow focused on tracking the "Big 3" daily tasks using real-time SQL status flags.
* Secret Journal Vault: Features a secondary gatekeeper authentication step to prevent over-the-shoulder snooping. Includes a 20-second temporal idle-watch system that automatically invalidates the journal session upon inactivity.
* Transactional Emailing: Integrated MailerSend SMTP service via PHP cURL to deliver real-time HTML emails during signup.
* Minimalist UI/UX: Designed with modern CSS Grid and Flexbox layouts using Urbanist typography and card-based containers. Includes "Focus Bear" motivational UX signals.

---

## Requirements & Local Setup (XAMPP)

1. Download and install XAMPP (with Apache & MySQL enabled).
2. Move/Clone this repository into your XAMPP web root directory:
   - Path: C:\xampp\htdocs\organizer (or your corresponding path)
3. Start the Apache and MySQL modules from the XAMPP Control Panel.
4. Import the relational database tables (`users`, `goals`, `journal`) into phpMyAdmin (http://localhost/phpmyadmin).
5. Access the application in your browser at: `http://localhost/organizer`

---

## Architecture & Security

* Password Security: Implements BCrypt one-way salt-and-hash algorithms (`password_hash` and `password_verify`) for secure user authentication.
* Temporal Logic: Automatically revokes vault access if the session elapsed time exceeds 20 seconds.
* Modular Logic: Structured with PHP/MySQL relational data mapping.

---

## Database Schema

[users]
- Columns: id, full_name, email, password
- Purpose: Core authentication & user profile management

[goals]
- Columns: id, user_id, task, status
- Purpose: Daily task prioritization and real-time status tracking

[journal]
- Columns: id, user_id, entry, created_at
- Purpose: Private reflections with second-wall security

---

## Tech Stack

* Backend: Modular PHP, MySQL, REST API Integration (MailerSend via cURL)
* Frontend: HTML5, Responsive CSS (Grid & Flexbox), Urbanist Font
* Security: BCrypt Hashing, Session Timeout Logic, Secondary Gatekeeper

---


* Phase 4: Real-time notifications via WebSockets
* Phase 5: Mobile application conversion via React Native
* Phase 6: AI-driven goal prioritization
