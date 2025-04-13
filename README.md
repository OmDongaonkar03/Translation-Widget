# Translation Widget

A simple, drop-in solution to translate any webpage content using Google's Gemini 1.5 Pro API. Add a single line of code to your website and give your visitors the ability to view your content in their preferred language.

## Features

- 🔌 Easy integration with a single `<script>` tag
- 🌐 Support for numerous languages via ISO language codes
- ⚡ Real-time translation without page reload
- 🎛️ Automatic language selector widget
- 🧠 Powered by Google's Gemini 1.5 Pro AI model

## How It Works

The Translation Widget consists of two main components:

1. **Frontend Script (`widget.js`)**: 
   - Collects all visible text from your webpage
   - Communicates with the backend via AJAX
   - Replaces original text with translations
   - Adds a language selector to the top-right corner

2. **Backend Script (`translate.php`)**:
   - Receives text from the frontend
   - Constructs a prompt for the Gemini API
   - Handles communication with Google's Gemini 1.5 Pro API
   - Returns translated content back to the frontend

## Setup Instructions

### Step 1: Get a Gemini API Key

1. Go to [Google AI Studio](https://aistudio.google.com/)
2. Create an account or sign in
3. Navigate to the API section and generate an API key

### Step 2: Configure the Backend

1. Download both `widget.js` and `translate.php`
2. Open `translate.php` and replace the placeholder API key:

```php
$apiKey = "YOUR_API_KEY"; // Replace with your actual Gemini API key
```

3. Upload both files to your web server

### Step 3: Add to Your Website

Add the following script tag to your website's HTML, just before the closing `</body>` tag:

```html
<script src="path/to/widget.js"></script>
```

That's it! Your website now has translation capabilities.

## File Structure

```
your-website/
├── index.html
├── ...
├── widgets/
│   ├── widget.js     # Frontend script
│   └── translate.php # Backend script
└── ...
```

## Language Support

The widget currently includes below languages. Use standard ISO language codes when configuring languages:

- `en` - English
- `es` - Spanish
- `fr` - French
- `hi` - Hindi
  
- You can add more as per your wish!

## Customization

You can customize the appearance of the language selector by modifying the CSS in `widget.js`. Look for the `.translation-selector` class to style the dropdown menu.

## Limitations

- The widget is designed for English source content. For other source languages, modifications may be required.
- Very large pages may need to be broken down into smaller translation chunks.
- API rate limits from Google may apply depending on your usage tier.

## License
MIT License
