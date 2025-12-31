# CLAUDE.md - Resend Email Integration Learning Project

## Project Overview
**Purpose:** Learning project to properly implement Resend API email integration with industry-standard backend practices.

**Goal:** Build a simple inquiry form system that demonstrates professional email handling, AWS S3 file storage, and production-ready code quality suitable for portfolio/GitHub showcase.

**Tech Stack:**
- Laravel 11
- Resend API (transactional emails)
- AWS S3 (file storage)
- PostgreSQL (database)
- Render (deployment platform)

---

## Project Scope

### What This Project Demonstrates
- ✅ Third-party API integration (Resend)
- ✅ Cloud file storage (AWS S3)
- ✅ Asynchronous job processing (queues)
- ✅ Proper error handling and logging
- ✅ Security best practices (rate limiting, validation, sanitization)
- ✅ Production-ready architecture
- ✅ Testing fundamentals
- ✅ Professional documentation

### User Flow
1. User visits inquiry form on website
2. User fills out:
   - Email address (required)
   - City selection (Vancouver, Coquitlam, Burnaby, Port Coquitlam)
   - Items array (up to 10 items), each item containing:
     - Photos (up to 3 per item, 2MB each, jpeg/png/webp)
     - Details/description (required)
   - Additional details (optional text field)
3. Form validates input (email format, file types, sizes, etc.)
4. System saves inquiry to database
5. System uploads photos to AWS S3 (if provided)
6. System queues two emails:
   - Company notification (to business email)
   - User confirmation (to user's email)
7. Background worker processes emails via Resend API
8. System tracks email delivery status

---

## Current Status

### Completed
- ✅ Laravel 12 project initialized
- ✅ Git repository created and pushed to GitHub
- ✅ Resend account created
- ✅ AWS S3 account created
- ✅ Resend SDK installed (`resend/resend-php`)
- ✅ Environment variables configured (RESEND_API_KEY, mail settings)
- ✅ Laravel Mail driver configured to use Resend
- ✅ CSRF exemption configured for webhook routes
- ✅ OrderInquiryRequest validation created with:
  - Email validation (rfc format)
  - City validation (Vancouver area cities)
  - Nested items array support (up to 10 items)
  - Multiple photo uploads per item (up to 3 photos, 2MB each)
  - MIME type validation (jpeg, jpg, png, webp)
  - Text field validation (details, additional_details)
- ✅ API test route created (`/api/send`)
- ✅ TestController created for testing email sending
- ✅ Postman testing validated

### In Progress
- [ ] Database migrations (inquiries, email_logs, jobs tables)
- [ ] AWS S3 integration for file uploads
- [ ] InquiryController (production endpoint)

### Blocked/Waiting
- [ ] None

### Next Steps
1. Create database migrations (inquiries, email_logs, jobs)
2. Set up AWS S3 configuration and file upload handling
3. Create Mailable classes (CompanyNotification, UserConfirmation)
4. Create Queue Jobs for async email sending
5. Implement InquiryController with full logic
6. Add rate limiting middleware
7. Create webhook handler for Resend events
8. Write feature tests

---

## Architecture Decisions

### Why Resend?
- Modern API-first approach
- 3,000 emails/month free tier (100/day)
- Better developer experience than traditional SMTP
- No sandbox restrictions (can send to any email immediately)
- Industry-relevant skill

### Why AWS S3?
- Industry standard for file storage
- Resume-worthy skill
- 5GB free tier (12 months)
- Scalable and reliable
- Transferable knowledge to other S3-compatible services

### Why Queue System?
- Non-blocking user experience (immediate form response)
- Automatic retry on failures
- Better error handling
- Industry standard for email sending
- Handles API rate limits gracefully

### Why PostgreSQL?
- Production-grade database
- JSON support for metadata
- Better for deployment on Render
- Industry standard

---

## Industry-Standard Features To Implement

### ⭐ CRITICAL (Must Have)
1. **Email Queue System**
   - Status: [ ] Not started
   - Queue connection configured (database)
   - Laravel Jobs for async email sending
   - Queue worker process
   - Failed job handling with retries

2. **Comprehensive Logging**
   - Status: [ ] Not started
   - Structured logging for all email attempts
   - Separate log channel for emails
   - Contextual data (recipient, type, inquiry_id)
   - Note: Don't log validation errors (422) - only system failures

3. **Database Email Tracking**
   - Status: [ ] Not started
   - `email_logs` table
   - Fields: recipient, type, status, sent_at, bounced_at, error_message
   - Linked to inquiries table

4. **Rate Limiting (Multiple Layers)**
   - Status: [ ] Not started
   - Per-IP throttling (5 submissions/hour)
   - Per-email throttling (3 submissions/day)
   - API route throttling
   - Optional: CAPTCHA integration

5. **Input Validation & Sanitization**
   - Status: [✅] Completed
   - FormRequest class created (OrderInquiryRequest)
   - Email format validation (rfc)
   - File upload validation (type, size, mime)
   - Nested array validation for items and photos
   - Max limits: 10 items, 3 photos per item, 2MB per file
   - Allowed formats: jpeg, jpg, png, webp
   - Note: DNS validation available but not enabled (adds latency)

6. **Error Handling & Graceful Degradation**
   - Status: [ ] In progress
   - Validation errors return proper 422 responses
   - Try-catch blocks needed for email sending
   - Inquiry saved to DB even if email fails (TODO)
   - User receives success response (TODO)
   - Admin alerts for persistent failures (TODO)

7. **Environment-Based Configuration**
   - Status: [✅] Completed
   - All credentials in `.env` (RESEND_API_KEY, mail settings)
   - Mail driver configured (resend)
   - Sandbox domain configured (onboarding@resend.dev)
   - `.env.example` needs updating with new variables

8. **AWS S3 Integration**
   - Status: [ ] Not started
   - S3 credentials in .env (keys present but not configured)
   - Image upload to S3 bucket (TODO)
   - URL stored in database (TODO)
   - Public/private file handling (TODO)
   - File validation completed ✅

9. **Documentation**
   - Status: [ ] Not started
   - README.md with setup instructions
   - Inline code comments
   - Environment variables documented
   - API documentation (if applicable)

### ⭐ IMPORTANT (Should Have)
10. **Webhook Handler for Bounces**
    - Status: [ ] Not started
    - Endpoint to receive Resend events
    - Handle bounce events (mark email invalid)
    - Handle complaint events
    - Webhook signature verification

11. **Email Template Management**
    - Status: [ ] Not started
    - Blade components for layouts
    - Reusable header/footer
    - Mobile-responsive design
    - Plain text alternative

12. **Basic Testing**
    - Status: [ ] Not started
    - Feature test for form submission
    - Mock Resend API in tests
    - Test S3 upload
    - Minimum: happy path test

### ⭐ NICE TO HAVE (Bonus)
13. **Monitoring Dashboard**
    - Status: [ ] Not started (optional)
    - Email delivery statistics
    - Bounce rate tracking
    - Failed job monitoring

14. **Idempotency**
    - Status: [ ] Not started (optional)
    - Prevent duplicate submissions
    - Unique constraint on email + timestamp window

---

## File Structure
```
app/
├── Http/
│   ├── Controllers/
│   │   └── Api/
│   │       └── InquiryController.php (API endpoint for form submission)
│   │   └── WebhookController.php (Resend webhooks - web route)
│   ├── Requests/
│   │   └── OrderInquiryRequest.php (validation logic)
│   └── Middleware/
│       └── ThrottleInquiries.php (custom rate limiting - optional)
├── Jobs/
│   ├── SendCompanyNotificationEmail.php
│   └── SendUserConfirmationEmail.php
├── Models/
│   ├── Inquiry.php
│   └── EmailLog.php
└── Mail/
    ├── CompanyNotification.php (Mailable)
    └── UserConfirmation.php (Mailable)

resources/
└── views/
    └── emails/
        ├── layouts/
        │   └── base.blade.php (shared email layout)
        ├── company-notification.blade.php
        └── user-confirmation.blade.php

database/
└── migrations/
    ├── xxxx_create_inquiries_table.php
    ├── xxxx_create_email_logs_table.php
    └── xxxx_create_jobs_table.php (for queue)

routes/
├── api.php (main API routes - inquiry endpoint)
└── web.php (webhook routes only - no CSRF)

tests/
└── Feature/
    └── Api/
        └── OrderInquirySubmissionTest.php
```

---

## API Routes

### Public Endpoints
```
POST /api/inquiries (production endpoint - TODO)
POST /api/send (test endpoint - active)

Request Body (form-data):
- email: string (required, validated with rfc format)
- city: string (required, one of: vancouver, coquitlam, burnaby, port coquitlam)
- items: array (nullable, max 10 items)
  - items[*][photos]: array (nullable, max 3 photos per item)
    - items[*][photos][*]: file (jpeg/jpg/png/webp, max 2MB)
  - items[*][details]: string (required, max 5000 chars)
- additional_details: string (nullable, max 8000 chars)

Response (Success):
{ "message": "Sent by user@example.com" }

Response (Validation Error - 422):
{
  "message": "The email field must be a valid email address.",
  "errors": {
    "email": ["The email field must be a valid email address."],
    "items.0.photos.0": ["The file must be an image."]
  }
}

Rate limiting: TODO (5 per hour per IP, 3 per day per email)
```

### Webhook Endpoints
```
POST /webhooks/resend
- Accepts: Resend webhook events
- Handles: email.bounced, email.complained, email.delivered
- No CSRF protection (verified via signature)
```

---

## DNS Configuration Checklist

### Required Records (from Resend Dashboard)
- [ ] SPF record (TXT) - Format: `v=spf1 include:_spf.resend.com ~all`
- [ ] DKIM record (TXT) - Provided by Resend (unique key)
- [ ] DMARC record (TXT) - Optional: `v=DMARC1; p=none; rua=mailto:dmarc@yourdomain.com`

### Domain Verification
- [ ] Records added to domain registrar
- [ ] DNS propagation confirmed (dnschecker.org)
- [ ] Domain shows "Verified" in Resend dashboard
- [ ] Test email sent from verified domain
- [ ] Email passed spam checks (mail-tester.com score 8+)

---

## Testing Checklist

### Before Deployment
- [ ] Test email sending locally
- [ ] Test with invalid email addresses
- [ ] Test file upload (valid image)
- [ ] Test file upload (invalid file type)
- [ ] Test file upload (oversized file)
- [ ] Test rate limiting (submit form 6+ times quickly)
- [ ] Test error handling (disconnect internet, submit form)
- [ ] Verify emails arrive at: Gmail, Outlook, Yahoo
- [ ] Verify emails not in spam folder
- [ ] Verify email content renders correctly on mobile
- [ ] Run `php artisan test`

### After Deployment
- [ ] Submit form on live site
- [ ] Verify both emails received
- [ ] Check Resend dashboard for delivery status
- [ ] Check Render logs for errors
- [ ] Verify S3 images accessible
- [ ] Test from different devices/browsers
- [ ] Monitor for 24 hours

---

## Known Issues / Gotchas

### DNS Propagation
- Can take 24-48 hours for DNS records to propagate globally
- Test with online tools: dnschecker.org, whatsmydns.net
- Resend won't verify domain until propagation complete

### Resend Rate Limits (Free Tier)
- 100 emails/day = 50 form submissions/day (2 emails per submission)
- Monitor usage in Resend dashboard
- Upgrade plan available if limits exceeded

### AWS S3 Free Tier
- 5GB storage for first 12 months only
- After 12 months: ~$0.023 per GB/month
- 2,000 PUT requests/month free
- 20,000 GET requests/month free

### Queue Worker on Render
- Must run as separate worker service (costs apply after free tier)
- Free tier: 750 hours/month shared across services
- Worker crashes: auto-restart enabled
- Failed jobs: retry 3 times then log to `failed_jobs` table

### Image Upload Security
- Always validate MIME type, not just extension
- Limit file size (recommend 5MB max)
- Consider virus scanning for production (ClamAV)
- Use signed URLs for private files

---

## Resources & Documentation

### Resend
- Dashboard: https://resend.com/dashboard
- Documentation: https://resend.com/docs
- API Reference: https://resend.com/docs/api-reference
- Status Page: https://status.resend.com

### AWS S3
- Console: https://console.aws.amazon.com/s3
- Laravel Documentation: https://laravel.com/docs/11.x/filesystem#amazon-s3-compatible-filesystems
- IAM Setup: https://docs.aws.amazon.com/IAM/latest/UserGuide/id_users_create.html

### Laravel
- Queue Documentation: https://laravel.com/docs/11.x/queues
- Mail Documentation: https://laravel.com/docs/11.x/mail
- Validation: https://laravel.com/docs/11.x/validation

### Tools
- Mail Tester: https://www.mail-tester.com (spam score checker)
- DNS Checker: https://dnschecker.org (verify DNS propagation)
- Render: https://dashboard.render.com

---

## Learning Objectives

By completing this project, I will understand:
- ✅ How to integrate third-party APIs professionally
- ✅ Async job processing with queues
- ✅ Cloud file storage patterns (S3)
- ✅ Email deliverability (SPF, DKIM, DMARC)
- ✅ Production-grade error handling
- ✅ Security best practices (rate limiting, validation)
- ✅ Webhook implementation
- ✅ Testing external services
- ✅ Deployment workflows
- ✅ Professional documentation standards

---

## Portfolio Value

### GitHub Repository Highlights
- Public repo showcasing clean Laravel code
- Demonstrates AWS integration experience
- Shows understanding of async processing
- Professional README and documentation
- Commit history shows development process
- Tests included (quality assurance mindset)

### Resume Talking Points
- "Implemented production-ready email system with Resend API"
- "Integrated AWS S3 for scalable file storage"
- "Built asynchronous job processing with Laravel Queues"
- "Configured email deliverability (SPF/DKIM/DMARC)"
- "Implemented multi-layer rate limiting and security measures"

---

**Last Updated:** 2025-12-31