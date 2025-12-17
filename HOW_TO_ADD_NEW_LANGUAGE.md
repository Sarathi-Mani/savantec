# How to Add a New Language to SellfizERP

There are two ways to add a new language to your application:

## Method 1: Using the Admin Interface (Recommended)

If you're logged in as a **Super Admin**, you can add languages through the web interface:

### Steps:
1. **Navigate to Language Management**
   - Go to: `Settings` → `Language` (or visit `/manage-language/en`)
   - You need to be a Super Admin to access this

2. **Create New Language**
   - Click the "Create Language" button
   - Fill in the form:
     - **Language Code**: Use ISO 639-1 code (e.g., `hi` for Hindi, `ko` for Korean, `vi` for Vietnamese)
     - **Language Name**: Full name (e.g., `Hindi`, `Korean`, `Vietnamese`)
   - Click "Create"

3. **Translate the Language**
   - After creation, you'll be redirected to the language management page
   - Translate all the strings in the JSON file and PHP files
   - Click "Save" when done

### What Happens Automatically:
- Creates a new folder in `resources/lang/[code]/` with all necessary PHP files
- Creates a `[code].json` file in `resources/lang/`
- Adds the language to the `languages` database table
- Copies all English translations as a starting point

---

## Method 2: Manual Method (For Developers)

If you prefer to add a language manually:

### Step 1: Create Language Files

1. **Create the language directory:**
   ```bash
   mkdir resources/lang/[language_code]
   ```
   Example: `mkdir resources/lang/hi` for Hindi

2. **Copy English files as template:**
   ```bash
   # Copy the entire English directory
   cp -r resources/lang/en resources/lang/[language_code]
   
   # Copy the JSON file
   cp resources/lang/en.json resources/lang/[language_code].json
   ```
   Example:
   ```bash
   cp -r resources/lang/en resources/lang/hi
   cp resources/lang/en.json resources/lang/hi.json
   ```

### Step 2: Add to Database

Add the language to the `languages` table:

```sql
INSERT INTO languages (code, full_name, created_at, updated_at) 
VALUES ('hi', 'Hindi', NOW(), NOW());
```

Or use Laravel Tinker:
```bash
php artisan tinker
```
Then:
```php
\App\Models\Language::create([
    'code' => 'hi',
    'full_name' => 'Hindi'
]);
```

### Step 3: Update Utility Model (Optional)

If you want the language to appear in the default language list, add it to `app/Models/Utility.php` in the `langList()` method around line 3742:

```php
$languages = [
    "ar" => "Arabic",
    "zh" => "Chinese",
    "da" => "Danish",
    "de" => "German",
    "en" => "English",
    "es" => "Spanish",
    "fr" => "French",
    "he" => "Hebrew",
    "hi" => "Hindi",  // Add your new language here
    "it" => "Italian",
    // ... rest of languages
];
```

### Step 4: Translate the Files

1. **Translate the JSON file:**
   - Edit `resources/lang/[code].json`
   - Translate all the key-value pairs

2. **Translate PHP files:**
   - Edit files in `resources/lang/[code]/`:
     - `auth.php` - Authentication messages
     - `pagination.php` - Pagination text
     - `passwords.php` - Password reset messages
     - `validation.php` - Form validation messages
     - `installer_messages.php` - Installer messages

### Step 5: Test the Language

1. Log in as a user
2. Change your language preference
3. Verify all translations appear correctly

---

## Language File Structure

```
resources/lang/
├── [language_code]/          # e.g., hi/
│   ├── auth.php
│   ├── pagination.php
│   ├── passwords.php
│   ├── validation.php
│   └── installer_messages.php
└── [language_code].json      # e.g., hi.json
```

---

## Important Notes

1. **Language Codes**: Use ISO 639-1 two-letter codes (e.g., `en`, `es`, `fr`, `hi`, `ko`)

2. **RTL Languages**: If adding an RTL (Right-to-Left) language like Arabic or Hebrew:
   - The system automatically sets `SITE_RTL` to `on` when users select these languages
   - Currently supported RTL: `ar` (Arabic), `he` (Hebrew)

3. **Default Language**: The default language is set in Settings → System Settings → Default Language

4. **Disabling Languages**: You can disable languages from the language management page without deleting them

5. **Translation Files**:
   - `.json` file: Contains most UI translations
   - PHP files: Contain system messages (auth, validation, etc.)

---

## Example: Adding Hindi (hi)

1. **Via Admin Interface:**
   - Go to `/manage-language/en`
   - Click "Create Language"
   - Code: `hi`
   - Name: `Hindi`
   - Click Create
   - Translate all strings

2. **Manually:**
   ```bash
   # Create directory
   mkdir resources/lang/hi
   
   # Copy English files
   cp -r resources/lang/en/* resources/lang/hi/
   cp resources/lang/en.json resources/lang/hi.json
   
   # Add to database
   php artisan tinker
   ```
   ```php
   \App\Models\Language::create(['code' => 'hi', 'full_name' => 'Hindi']);
   ```

---

## Accessing Language Management

- **URL**: `/manage-language/[language_code]`
- **Example**: `/manage-language/en` to manage English translations
- **Required Role**: Super Admin only

---

## Troubleshooting

- **Language not showing**: Check if it's disabled in Settings → Language
- **Translations not working**: Clear cache: `php artisan cache:clear`
- **Missing translations**: Make sure both `.json` and PHP files are translated

