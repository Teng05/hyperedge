<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Module;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\QuizAttempt;
use App\Models\StudentModuleProgress;
use App\Models\Certificate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class RealCourseContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ─── 1. RESET AND PREPARE ─────────────────────────────────────────────
        $this->command->warn('Wiping any existing module/coursework related data...');
        Schema::disableForeignKeyConstraints();
        Certificate::truncate();
        StudentModuleProgress::truncate();
        QuizAttempt::truncate();
        Lesson::truncate();
        Question::truncate();
        Quiz::truncate();
        Module::truncate();
        Schema::enableForeignKeyConstraints();

        // ─── 2. FETCH FACILITATOR FOR MODULE ASSIGNMENT ───────────────────────────
        $teacher = User::where('role', 'teacher')->first();
        if (!$teacher) {
            $this->command->error('No facilitator user found! Please seed a facilitator user first.');
            return;
        }

        $this->command->info("Assigning seeded course modules to Facilitator: {$teacher->email}");

        // ─── 3. DEFINE COURSE MODULES & LESSONS DATA STRUCTURE ───────────────
        $courseData = array (
  0 => 
  array (
    'title' => 'Module 1: Introduction to HTML',
    'description' => 'Learn the absolute basics of HTML5, including document structure, key tags, and setting up your development environment.',
    'order' => 1,
    'lessons' => 
    array (
      0 => 
      array (
        'title' => 'HTML Introduction',
        'type' => 'ppt',
        'order' => 1,
        'ppt_slides' => 
        array (
          0 => 
          array (
            'title' => 'ACADEMY',
            'content' => 'HTML INTRODUCTION
UNDERSTANDING THE BASICS',
          ),
          1 => 
          array (
            'title' => 'A SIMPLE HTML DOCUMENT',
            'content' => '<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
</head>
<body>
<h1>My First Heading</h1>
<p>My first paragraph.</p>
</body>
</html>',
          ),
          2 => 
          array (
            'title' => 'WHAT EACH PART MEANS <!DOCTYPE html>  → Declaration that this',
            'content' => 'is HTML5
<html>           → Start of HTML document
<head>           → Container for metadata
<title>          → Sets the page title
(browser tab)
<body>           → All VISIBLE content
goes here
<h1>             → Main heading
<p>              → Paragraph text',
          ),
          3 => 
          array (
            'title' => 'HTML TAGS EXPLAINED',
            'content' => 'HTML tags are keywords surrounded by angle brackets:
<tag> content </tag>
↑       ↑        ↑
Start   Content  End tag
tag            (closing)
Examples:
<h1>Heading</h1>
<p>Paragraph</p>
<img src="image.jpg"> (self-closing)',
          ),
        ),
        'code_snippet' => '<!DOCTYPE html>
<html>
<head>
  <title>My First HTML Page</title>
</head>
<body>
  <h1>Hello World</h1>
  <p>This is my first paragraph!</p>
</body>
</html>',
        'video_url' => 'https://www.youtube.com/embed/pBCG_Y7fTCs',
        'video_explanation' => 'In this subtopic lesson, we cover HTML Introduction. Read the slides, review the code snippet, and click \'Open Sandbox Playground\' to complete the challenge validator checklist.',
      ),
      1 => 
      array (
        'title' => 'HTML Home Basics',
        'type' => 'ppt',
        'order' => 2,
        'ppt_slides' => 
        array (
          0 => 
          array (
            'title' => 'ACADEMYMODULE 1:',
            'content' => 'INTRODUCTION TO HTML
HTML HOME',
          ),
          1 => 
          array (
            'title' => 'WHAT IS HTML?',
            'content' => 'HTML = Hyper Text Markup Language
• Standard language for creating Web pages
• Describes the structure of a Web page
• Uses elements/tags to mark content
• Not a programming language - it\'s a markup
language',
          ),
          2 => 
          array (
            'title' => 'HTML DOCUMENT‌',
            'content' => '‌STRUCTURE
EVERY HTML DOCUMENT HAS THIS BASIC STRUCTURE:
<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
</head>
<body>
<h1>My First Heading</h1>
<p>My first paragraph.</p>
</body>
</html>',
          ),
          3 => 
          array (
            'title' => 'UNDERSTANDING THE TAGS PURPOSE',
            'content' => 'TAG
<!DOCTYPE html>
<html>
<body>
<title>
<head>
SETS BROWSER TAB TITLE
CONTAINS VISIBLE CONTENT
CONTAINS META INFORMATION
DECLARES HTML5 DOCUMENT TYPE
ROOT ELEMENT OF THE PAGE',
          ),
          4 => 
          array (
            'title' => 'HOW BROWSERS DISPLAY HTML',
            'content' => '1. Browser reads HTML file
2. Interprets the tags
3. Renders content on screen
4. Applies default styling',
          ),
        ),
        'code_snippet' => '<!DOCTYPE html>
<html>
<body>
  <h1>Welcome to HyperEdge</h1>
  <p>HTML is the standard markup language for Web pages.</p>
</body>
</html>',
        'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        'video_explanation' => 'In this subtopic lesson, we cover HTML Home Basics. Read the slides, review the code snippet, and click \'Open Sandbox Playground\' to complete the challenge validator checklist.',
      ),
      2 => 
      array (
        'title' => 'HTML Editors Guide',
        'type' => 'ppt',
        'order' => 3,
        'ppt_slides' => 
        array (
          0 => 
          array (
            'title' => 'ACADEMYHTML EDITORS',
            'content' => 'TOOLS TO WRITE HTML CODE',
          ),
          1 => 
          array (
            'title' => 'SIMPLE TEXT EDITORS (FOR‌',
            'content' => '‌LEARNING)
Recommended for beginners:
Windows: Notepad
Mac: TextEdit
Why? It teaches you to write code manually
No auto-complete - you learn the syntax!',
          ),
          2 => 
          array (
            'title' => 'HOW TO USE NOTEPAD (WINDOWS)',
            'content' => 'Step 1: Open Notepad
• Windows 8+: Type "Notepad" in Start Screen
• Windows 7: Start > Programs > Accessories > Notepad
Step 2: Write HTML code
Step 3: Save as "index.html"
• File > Save As
• Name: index.html
• Encoding: UTF-8
Step 4: Open in browser (double-click the file)',
          ),
          3 => 
          array (
            'title' => 'HOW TO USE TEXTEDIT (MAC)',
            'content' => 'Step 1: Open TextEdit
• Finder > Applications > TextEdit
Step 2: Change Preferences
• Preferences > Format > "Plain Text"
Step 3: Under "Open and Save"
• Check "Display HTML files as HTML code"
Step 4: Write code and save as .html',
          ),
          4 => 
          array (
            'title' => 'PROFESSIONAL HTML EDITORS',
            'content' => 'For serious development:
• VS Code (Free, most popular)
• Sublime Text
• Atom
• WebStorm
Features: syntax highlighting, auto-
complete, live preview',
          ),
          5 => 
          array (
            'title' => 'W3SCHOOLS ONLINE EDITOR',
            'content' => '"Try it Yourself" Editor
• Free online tool
• Edit code and see results instantly
• No installation needed
• Great for testing code fast
Try it: w3schools.com (Click "Try it
Yourself")',
          ),
        ),
        'code_snippet' => '<!DOCTYPE html>
<html>
<head>
  <title>Editor Setup</title>
</head>
<body>
  <h1>Writing Code in Notepad</h1>
  <p>Write your markup manually without autocomplete to master syntax!</p>
</body>
</html>',
        'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        'video_explanation' => 'In this subtopic lesson, we cover HTML Editors Guide. Read the slides, review the code snippet, and click \'Open Sandbox Playground\' to complete the challenge validator checklist.',
      ),
    ),
    'quiz' => 
    array (
      'title' => 'Module 1 Assessment',
      'passing_score' => 4,
      'total_points' => 5,
      'questions' => 
      array (
        0 => 
        array (
          'question_text' => 'What is the correct HTML code to create a basic HTML document structure?',
          'choices' => 
          array (
            0 => '<html><body>Hello</body></html>',
            1 => '<!DOCTYPE html><html><head></head><body>Hello</body></html>',
            2 => '<html><head></head>Hello</html>',
            3 => '<!DOCTYPE>Hello</html>',
          ),
          'correct_answer' => '<!DOCTYPE html><html><head></head><body>Hello</body></html>',
        ),
        1 => 
        array (
          'question_text' => 'Look at this code. What will display in the browser tab?

```html
<html>
<head>
<title>My Website</title>
</head>
<body>
<h1>Welcome</h1>
</body>
</html>
```',
          'choices' => 
          array (
            0 => 'Welcome',
            1 => 'My Website',
            2 => 'Welcome - My Website',
            3 => 'Nothing displays',
          ),
          'correct_answer' => 'My Website',
        ),
        2 => 
        array (
          'question_text' => 'Which HTML tag contains all VISIBLE content of a webpage?',
          'choices' => 
          array (
            0 => '<head>',
            1 => '<html>',
            2 => '<body>',
            3 => '<title>',
          ),
          'correct_answer' => '<body>',
        ),
        3 => 
        array (
          'question_text' => 'You saved a file as "mywebpage.html". What happens when you double-click it?',
          'choices' => 
          array (
            0 => 'Opens in code editor',
            1 => 'Opens in web browser',
            2 => 'Asks what program to use',
            3 => 'Nothing, it\'s not a program',
          ),
          'correct_answer' => 'Opens in web browser',
        ),
        4 => 
        array (
          'question_text' => 'What does HTML stand for?',
          'choices' => 
          array (
            0 => 'Hyper Text Markup Language',
            1 => 'Home Tool Markup Language',
            2 => 'Hyperlinks Text Mark Language',
            3 => 'High Tech Modern Language',
          ),
          'correct_answer' => 'Hyper Text Markup Language',
        ),
      ),
    ),
  ),
  1 => 
  array (
    'title' => 'Module 2: HTML Basics & Structure',
    'description' => 'Understand core HTML elements, standard document flows, nesting elements, horizontal rules, line breaks, and common attribute syntax.',
    'order' => 2,
    'lessons' => 
    array (
      0 => 
      array (
        'title' => 'HTML Basic Document Examples',
        'type' => 'ppt',
        'order' => 1,
        'ppt_slides' => 
        array (
          0 => 
          array (
            'title' => 'ACADEMYMODULE 2: HTML BASICS  HTML BASIC EXAMPLES',
            'content' => 'BUILDING YOUR FIRST WEB PAGE',
          ),
          1 => 
          array (
            'title' => '‌HTML DOCUMENTS',
            'content' => 'All HTML documents MUST start with:
<!DOCTYPE html>
Then the structure:
<html>
<body>
... visible content ...
</body>
</html>',
          ),
          2 => 
          array (
            'title' => 'THE <!DOCTYPE>‌',
            'content' => '‌DECLARATION
Purpose: Tells the browser which HTML version to use
For HTML5 (current version):
<!DOCTYPE html>
NOT case sensitive
Must be at the VERY TOP of the page
Appears only ONCE',
          ),
          3 => 
          array (
            'title' => 'HEADINGS IN HTML <h1>Most important heading</h1>',
            'content' => '<h2>Heading 2</h2>
<h3>Heading 3</h3>
<h4>Heading 4</h4>
<h5>Heading 5</h5>
<h6>Least important heading</h6>',
          ),
          4 => 
          array (
            'title' => 'PARAGRAPHS IN HTML',
            'content' => '<p>This is a paragraph.</p>
<p>This is another paragraph.</p>
Note: Browsers automatically add blank
lines before and after paragraphs.',
          ),
          5 => 
          array (
            'title' => 'HOW TO VIEW HTML SOURCE',
            'content' => 'Method 1: CTRL + U (Windows/Linux)
Command + U (Mac)
Method 2: Right-click → "View Page Source"
Method 3: Right-click → "Inspect" (see live code)
Great way to learn from other websites!',
          ),
        ),
        'code_snippet' => '<!DOCTYPE html>
<html>
<body>
  <h1>Shop is Open</h1>
  <p>Open today</p>
  <hr>
  <p>Come visit us</p>
</body>
</html>',
        'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        'video_explanation' => 'In this subtopic lesson, we cover HTML Basic Document Examples. Read the slides, review the code snippet, and click \'Open Sandbox Playground\' to complete the challenge validator checklist.',
      ),
      1 => 
      array (
        'title' => 'HTML Elements & Nested Structures',
        'type' => 'ppt',
        'order' => 2,
        'ppt_slides' => 
        array (
          0 => 
          array (
            'title' => 'ACADEMYHTML ELEMENTS  UNDERSTANDING TAGS AND CONTENT',
            'content' => '',
          ),
          1 => 
          array (
            'title' => 'WHAT IS AN HTML ELEMENT?  An HTML element = Start tag + content + End tag',
            'content' => '< tagname > content < /tagname >
↑                    ↑
Start tag             End tag
Example:
<h1>My First Heading</h1>
<p>My first paragraph.</p>',
          ),
          2 => 
          array (
            'title' => 'NESTED HTML ELEMENTS  Elements can contain other elements:<html>',
            'content' => '<body>
<h1>Heading</h1>
<p>Paragraph</p>
</body>
</html>
<html> contains <body>
<body> contains <h1> and <p>',
          ),
          3 => 
          array (
            'title' => 'EMPTY HTML ELEMENTS  Some elements have no content (no end tag needed): <br>  → Line break',
            'content' => '<hr>  → Horizontal line
They CAN be written with closing slash:
<br/> or <hr/> (for stricter validation)',
          ),
          4 => 
          array (
            'title' => 'WHAT IS AN HTML ELEMENT?  An HTML element = Start tag + content + End tag',
            'content' => '< tagname > content < /tagname >
↑                    ↑
Start tag             End tag
Example:
<h1>My First Heading</h1>
<p>My first paragraph.</p>',
          ),
          5 => 
          array (
            'title' => 'NESTED HTML ELEMENTS  Elements can contain other elements:<html>',
            'content' => '<body>
<h1>Heading</h1>
<p>Paragraph</p>
</body>
</html>
<html> contains <body>
<body> contains <h1> and <p>',
          ),
          6 => 
          array (
            'title' => 'EMPTY HTML ELEMENTS  Some elements have no content (no end tag needed): <br>  → Line break',
            'content' => '<hr>  → Horizontal line
They CAN be written with closing slash:
<br/> or <hr/> (for stricter validation)',
          ),
          7 => 
          array (
            'title' => '‌COMMON HTML ELEMENTS REFERENCE  Element                           Description',
            'content' => '<html>                      Root of HTML document
<body>                      Visible content
<h1>-<h6>                   Headings
<p>                         Paragraph
<br>                        Line break
<hr>                        Horizontal rule
W3Schools HTML Element Reference',
          ),
        ),
        'code_snippet' => '<!DOCTYPE html>
<html>
<body>
  <div>
    <h1>Nest Elements</h1>
    <p>This paragraph is nested inside a division block.</p>
  </div>
</body>
</html>',
        'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        'video_explanation' => 'In this subtopic lesson, we cover HTML Elements & Nested Structures. Read the slides, review the code snippet, and click \'Open Sandbox Playground\' to complete the challenge validator checklist.',
      ),
      2 => 
      array (
        'title' => 'HTML Attributes & Metadata',
        'type' => 'ppt',
        'order' => 3,
        'ppt_slides' => 
        array (
          0 => 
          array (
            'title' => 'ACADEMYHTML ATTRIBUTES  ADDING EXTRA INFORMATION TO ELEMENTS',
            'content' => '',
          ),
          1 => 
          array (
            'title' => 'WHAT ARE ATTRIBUTES?  Attributes provide additional information about',
            'content' => 'elements
Syntax:
<tag attribute="value">content</tag>
Always in start tag
Name/value pairs (name="value")
Usually lowercase',
          ),
          2 => 
          array (
            'title' => 'THE SRC AND ALT ATTRIBUTES‌',
            'content' => '‌(IMAGES)  <img src="w3schools.jpg" alt="W3Schools Logo">
↑                    ↑
image source         alternative text
src = file path to image
alt = description (for screen readers/broken
images)',
          ),
          3 => 
          array (
            'title' => 'THE STYLE ATTRIBUTE  <p style="color:red;">Red text</p>',
            'content' => '↑
CSS styling
Changes appearance: color, size, font, etc.',
          ),
          4 => 
          array (
            'title' => 'COMMON HTML ATTRIBUTES  Attribute        Used On             Purpose',
            'content' => 'href              <a>           Link destination
src              <img>          Image file path
alt              <img>          Alternative text
style        Most elements      CSS styling
class        Most elements      CSS class reference
id           Most elements      Unique identifier',
          ),
          5 => 
          array (
            'title' => 'ACADEMY END OF THIS MODULE THANK YOU!',
            'content' => '',
          ),
        ),
        'code_snippet' => '<!DOCTYPE html>
<html>
<body>
  <h1 style="color:blue;">Styled Header</h1>
  <p title="I am a tooltip">Hover over this paragraph to see the title attribute in action.</p>
</body>
</html>',
        'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        'video_explanation' => 'In this subtopic lesson, we cover HTML Attributes & Metadata. Read the slides, review the code snippet, and click \'Open Sandbox Playground\' to complete the challenge validator checklist.',
      ),
    ),
    'quiz' => 
    array (
      'title' => 'Module 2 Assessment',
      'passing_score' => 4,
      'total_points' => 5,
      'questions' => 
      array (
        0 => 
        array (
          'question_text' => 'Which is the CORRECT way to create a paragraph?',
          'choices' => 
          array (
            0 => '<para>Hello World</para>',
            1 => '<p>Hello World</p>',
            2 => '<paragraph>Hello World</paragraph>',
            3 => '<pg>Hello World</pg>',
          ),
          'correct_answer' => '<p>Hello World</p>',
        ),
        1 => 
        array (
          'question_text' => 'Look at this code. What will the output look like?

```html
<body>
<h1>Shop</h1>
<p>Open today</p>
<br>
<p>Come visit us</p>
</body>
```',
          'choices' => 
          array (
            0 => 'Shop (large) / Open today / (blank line) / Come visit us',
            1 => 'Shop (large) / Open today Come visit us (same line)',
            2 => 'Shop / Open today / Come visit us (all same size)',
            3 => 'Shop Open today Come visit us (no spaces)',
          ),
          'correct_answer' => 'Shop (large) / Open today / (blank line) / Come visit us',
        ),
        2 => 
        array (
          'question_text' => 'Which code creates a level 2 heading that says "Lessons"?',
          'choices' => 
          array (
            0 => '<h1>Lessons</h1>',
            1 => '<h2>Lessons</h2>',
            2 => '<h3>Lessons</h3>',
            3 => '<heading2>Lessons</heading2>',
          ),
          'correct_answer' => '<h2>Lessons</h2>',
        ),
        3 => 
        array (
          'question_text' => 'What does the `<!DOCTYPE html>` declaration do?',
          'choices' => 
          array (
            0 => 'Creates a heading',
            1 => 'Tells the browser this is HTML5 document',
            2 => 'Adds a title to the page',
            3 => 'Creates a paragraph',
          ),
          'correct_answer' => 'Tells the browser this is HTML5 document',
        ),
        4 => 
        array (
          'question_text' => 'Which code creates a horizontal line (thematic break)?',
          'choices' => 
          array (
            0 => '<line>',
            1 => '<hr>',
            2 => '<br>',
            3 => '<break>',
          ),
          'correct_answer' => '<hr>',
        ),
      ),
    ),
  ),
  2 => 
  array (
    'title' => 'Module 3: Text, Styling & Formatting',
    'description' => 'Learn text layout tags (headings, paragraphs), CSS inline style rules, visual text formatting options, quotations, and comments.',
    'order' => 3,
    'lessons' => 
    array (
      0 => 
      array (
        'title' => 'HTML Headings (h1 to h6)',
        'type' => 'ppt',
        'order' => 1,
        'ppt_slides' => 
        array (
          0 => 
          array (
            'title' => 'ACADEMYMODULE 3: TEXT AND‌',
            'content' => '‌FORMATTING  HTML HEADINGS
ORGANIZING CONTENT WITH TITLES',
          ),
          1 => 
          array (
            'title' => 'HEADING TAGS',
            'content' => '<h1>Heading 1</h1>  (largest, most
important)
<h2>Heading 2</h2>
<h3>Heading 3</h3>
<h4>Heading 4</h4>
<h5>Heading 5</h5>
<h6>Heading 6</h6>  (smallest)',
          ),
          2 => 
          array (
            'title' => 'HEADINGS ARE IMPORTANT!',
            'content' => 'Search engines use headings to index page structure
✅ DO: Use headings to show document hierarchy
❌ DON\'T: Use headings just to make text big/bold
Rule: <h1> for main title (ONCE per page)
<h2> for major sections
<h3> for sub-sections',
          ),
          3 => 
          array (
            'title' => 'CUSTOM HEADING SIZE <h1 style="font-size:60px;">Extra Large',
            'content' => 'Heading</h1>
Use CSS to change heading size
Default sizes can be overridden',
          ),
        ),
        'code_snippet' => '<!DOCTYPE html>
<html>
<body>
  <h1>Main Heading</h1>
  <h2>Sub-heading Level 2</h2>
  <h3>Sub-heading Level 3</h3>
</body>
</html>',
        'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        'video_explanation' => 'In this subtopic lesson, we cover HTML Headings (h1 to h6). Read the slides, review the code snippet, and click \'Open Sandbox Playground\' to complete the challenge validator checklist.',
      ),
      1 => 
      array (
        'title' => 'HTML Paragraphs & Spacing',
        'type' => 'ppt',
        'order' => 2,
        'ppt_slides' => 
        array (
          0 => 
          array (
            'title' => 'ACADEMYHTML PARAGRAPHS  ADDING TEXT CONTENT',
            'content' => '',
          ),
          1 => 
          array (
            'title' => 'THE <P> ELEMENT',
            'content' => '<p>This is a paragraph.</p>
<p>This is another paragraph.</p>
• Always starts on a new line
• Browsers add margin before/after
• Block-level element',
          ),
          2 => 
          array (
            'title' => 'LINE BREAKS VS PARAGRAPHS',
            'content' => 'Using <br> (line break):
<p>Line 1<br>Line 2<br>Line 3</p>
Result: Line 1
Line 2
Line 3 (no extra space)
<p> is for separate paragraphs (has spacing)
<br> is for line breaks inside same paragraph
Source: Wellesley College W3Schools Summary',
          ),
        ),
        'code_snippet' => '<!DOCTYPE html>
<html>
<body>
  <p style="text-align:center;">Centered paragraph text for design.</p>
</body>
</html>',
        'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        'video_explanation' => 'In this subtopic lesson, we cover HTML Paragraphs & Spacing. Read the slides, review the code snippet, and click \'Open Sandbox Playground\' to complete the challenge validator checklist.',
      ),
      2 => 
      array (
        'title' => 'HTML CSS Styling Properties',
        'type' => 'ppt',
        'order' => 3,
        'ppt_slides' => 
        array (
          0 => 
          array (
            'title' => 'ACADEMYHTML STYLES  STYLING WITH THE STYLE ATTRIBUTE',
            'content' => '',
          ),
          1 => 
          array (
            'title' => 'THE STYLE ATTRIBUTE',
            'content' => 'Syntax: style="property:value;"
Common CSS properties:
color      → text color
font-family → font type
font-size   → text size
text-align  → alignment',
          ),
          2 => 
          array (
            'title' => '‌STYLE EXAMPLES <p style="color:blue;">Blue text</p>',
            'content' => '<p style="font-family:verdana;">Verdana font</p>
<p style="font-size:20px;">Large text</p>
<p style="text-align:center;">Centered text</p>
<h1 style="background-color:yellow;">Yellow
background</h1>',
          ),
          3 => 
          array (
            'title' => 'USING MULTIPLE STYLES  <p style="color:red; font-size:18px;',
            'content' => 'text-align:center;">
Red, large, centered text
</p>
Separate styles with semicolons (;)
Multiple properties can be combined',
          ),
        ),
        'code_snippet' => '<!DOCTYPE html>
<html>
<body>
  <p style="color:green; font-size:24px;">Large green styled paragraph.</p>
</body>
</html>',
        'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        'video_explanation' => 'In this subtopic lesson, we cover HTML CSS Styling Properties. Read the slides, review the code snippet, and click \'Open Sandbox Playground\' to complete the challenge validator checklist.',
      ),
      3 => 
      array (
        'title' => 'HTML Text Formatting Options',
        'type' => 'ppt',
        'order' => 4,
        'ppt_slides' => 
        array (
          0 => 
          array (
            'title' => 'ACADEMYHTML TEXT FORMATTING  BOLD, ITALIC, AND MORE',
            'content' => '',
          ),
          1 => 
          array (
            'title' => 'FORMATTING ELEMENTS OVERVIEW  Tag                             Effect',
            'content' => '<b>                      Bold text
<strong>                 Important (bold)
<i>                      Italic text
<em>                     Emphasized (italic)
<mark>                   Highlighted
<small>                  Small text
<del>                    Deleted (strikethrough)
<ins>                    Inserted (underlined)
<sub>                    Subscript
<sup>                    Superscript',
          ),
          2 => 
          array (
            'title' => 'BOLD AND STRONG  <b>This text is bold</b> (no extra meaning)',
            'content' => '<strong>This text is important!</strong>
(bold + semantic meaning)
Result: Both look bold, but <strong> has
screen reader emphasis',
          ),
          3 => 
          array (
            'title' => 'ITALIC AND EMPHASIZED  <i>This text is italic</i> (technical terms,',
            'content' => 'thoughts)
<em>This text is emphasized</em> (verbal stress
by screen readers)
Result: Both look italic, but <em> has semantic
meaning',
          ),
          4 => 
          array (
            'title' => 'MARK, DEL, INS <mark>Highlighted text</mark>',
            'content' => '<del>Deleted text</del>  (strikethrough)
<ins>Inserted text</ins>  (underlined)
Example:
<p>My favorite color is <del>blue</del>
<ins>red</ins>.</p>
Result: My favorite color is ~~blue~~ red.',
          ),
          5 => 
          array (
            'title' => 'SUBSCRIPT AND‌',
            'content' => '‌SUPERSCRIPT  H<sub>2</sub>O  → H₂O (water)
E = mc<sup>2</sup>  → E = mc² (exponent)
• <sub> = text half character BELOW normal
line
• <sup> = text half character ABOVE normal
line',
          ),
        ),
        'code_snippet' => '<!DOCTYPE html>
<html>
<body>
  <p>This is <strong>strong bold text</strong> and this is <em>emphasized text</em>.</p>
  <p>Price: <del>$100</del> <ins>$80</ins></p>
  <p>Water Formula: H<sub>2</sub>O</p>
  <p>Einstein Equation: E = mc<sup>2</sup></p>
  <p>This is a <mark>highlighted word</mark> in yellow.</p>
</body>
</html>',
        'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        'video_explanation' => 'In this subtopic lesson, we cover HTML Text Formatting Options. Read the slides, review the code snippet, and click \'Open Sandbox Playground\' to complete the challenge validator checklist.',
      ),
      4 => 
      array (
        'title' => 'HTML Quotations & Citations',
        'type' => 'ppt',
        'order' => 5,
        'ppt_slides' => 
        array (
          0 => 
          array (
            'title' => 'ACADEMYHTML QUOTATIONS  QUOTING TEXT AND CITATIONS',
            'content' => '',
          ),
          1 => 
          array (
            'title' => 'KEY QUOTATION TAGS  Tag                           Purpose',
            'content' => '<q>              Short inline quotation
<blockquote>     Long block quotation
<cite>           Citation/title of work
<address>        Contact information',
          ),
          2 => 
          array (
            'title' => 'USING <Q> FOR SHORT‌',
            'content' => '‌QUOTES  <p>He said: <q>HTML is amazing!</q></p>
Result: He said: "HTML is amazing!"
(Browser adds quotation marks automatically)',
          ),
          3 => 
          array (
            'title' => 'USING <BLOCKQUOTE>  <blockquote',
            'content' => 'cite="https://www.example.com">
This is a longer quotation that gets
indented
and treated as a separate block of
text.
</blockquote>',
          ),
        ),
        'code_snippet' => '<!DOCTYPE html>
<html>
<body>
  <p>Tim Berners-Lee said: <q>The Web does not just connect machines, it connects people.</q></p>
</body>
</html>',
        'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        'video_explanation' => 'In this subtopic lesson, we cover HTML Quotations & Citations. Read the slides, review the code snippet, and click \'Open Sandbox Playground\' to complete the challenge validator checklist.',
      ),
      5 => 
      array (
        'title' => 'HTML Comments Best Practices',
        'type' => 'ppt',
        'order' => 6,
        'ppt_slides' => 
        array (
          0 => 
          array (
            'title' => 'ACADEMYHTML COMMENTS  ADDING NOTES IN YOUR CODE',
            'content' => '',
          ),
          1 => 
          array (
            'title' => 'COMMENT SYNTAX  <!-- Your comment goes here -->',
            'content' => 'Example:
<!-- This is a comment that will NOT display -
->
<p>This text is visible</p>
<!-- Comments help document your code -->',
          ),
          2 => 
          array (
            'title' => 'WHY USE COMMENTS? ✅ Explain complex code sections',
            'content' => '✅ Temporarily disable code (debugging)
✅ Leave reminders for yourself or team
✅ Organize large HTML files
<!-- HEADER SECTION START -->
<header>...</header>
<!-- HEADER SECTION END -->
NOT visible to users (only in source code)',
          ),
          3 => 
          array (
            'title' => 'COMMENT TIPS  Can be multi-line:',
            'content' => '<!--
This is a long comment
that spans multiple lines
for better explanation
-->
Cannot nest comments:
<!-- Outer <!-- Inner --> --> (WRONG!)',
          ),
          4 => 
          array (
            'title' => 'MODULE 3 FORMATTING TAGS',
            'content' => 'Text Formatting Cheat Sheet:
BOLD:      <b>text</b>  or
<strong>text</strong>
ITALIC:    <i>text</i>  or  <em>text</em>
SMALL:     <small>text</small>
MARK:      <mark>text</mark>
DELETED:   <del>text</del>
INSERTED:  <ins>text</ins>
SUBSCRIPT: H<sub>2</sub>O
SUPERSCRIPT: m<sup>2</sup>',
          ),
          5 => 
          array (
            'title' => 'ACADEMY END OF THIS MODULE THANK YOU!',
            'content' => '',
          ),
        ),
        'code_snippet' => '<!DOCTYPE html>
<html>
<body>
  <!-- This is a clean comment in HTML -->
  <h1>Visible Title</h1>
</body>
</html>',
        'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        'video_explanation' => 'In this subtopic lesson, we cover HTML Comments Best Practices. Read the slides, review the code snippet, and click \'Open Sandbox Playground\' to complete the challenge validator checklist.',
      ),
    ),
    'quiz' => 
    array (
      'title' => 'Module 3 Assessment',
      'passing_score' => 4,
      'total_points' => 5,
      'questions' => 
      array (
        0 => 
        array (
          'question_text' => 'Which code makes text BOLD with semantic meaning (screen readers emphasize)?',
          'choices' => 
          array (
            0 => '<b>Important</b>',
            1 => '<bold>Important</bold>',
            2 => '<strong>Important</strong>',
            3 => '<bld>Important</bld>',
          ),
          'correct_answer' => '<strong>Important</strong>',
        ),
        1 => 
        array (
          'question_text' => 'What will this code display?

```html
<p>Today is <del>Monday</del> <ins>Tuesday</ins>.</p>
```',
          'choices' => 
          array (
            0 => 'Today is Monday Tuesday.',
            1 => 'Today is Monday (with Monday struck through) Tuesday.',
            2 => 'Today is Monday (crossed out) Tuesday (underlined)',
            3 => 'Today is Monday Tuesday (both underlined)',
          ),
          'correct_answer' => 'Today is Monday (crossed out) Tuesday (underlined)',
        ),
        2 => 
        array (
          'question_text' => 'Which code displays water formula H₂O correctly?',
          'choices' => 
          array (
            0 => 'H<sub>2</sub>O',
            1 => 'H<sup>2</sup>O',
            2 => 'H<low>2</low>O',
            3 => 'H<small>2</small>O',
          ),
          'correct_answer' => 'H<sub>2</sub>O',
        ),
        3 => 
        array (
          'question_text' => 'What color and size will this text be?

```html
<p style="color:green; font-size:24px;">Hello</p>
```',
          'choices' => 
          array (
            0 => 'Green text, normal size',
            1 => 'Black text, large size',
            2 => 'Green text, large size',
            3 => 'Green text, red background',
          ),
          'correct_answer' => 'Green text, large size',
        ),
        4 => 
        array (
          'question_text' => 'Which tag creates a HIGHLIGHTED (yellow background) effect?',
          'choices' => 
          array (
            0 => '<highlight>',
            1 => '<yellow>',
            2 => '<mark>',
            3 => '<bg>',
          ),
          'correct_answer' => '<mark>',
        ),
      ),
    ),
  ),
  3 => 
  array (
    'title' => 'Module 4: Colors, Links, and Media Basics',
    'description' => 'Learn how to apply colors, create links/hyperlinks, add images, page titles, and configure tab favicons to build beautiful and navigate-friendly HTML pages.',
    'order' => 4,
    'lessons' => 
    array (
      0 => 
      array (
        'title' => 'HTML Page Title',
        'type' => 'ppt',
        'order' => 1,
        'ppt_slides' => 
        array (
          0 => 
          array (
            'title' => 'HTML PAGE TITLE',
            'content' => 'Every web page should have a page title to describe the meaning of the page.',
          ),
          1 => 
          array (
            'title' => 'TITLE ELEMENT',
            'content' => 'The <title> element adds a title to your page

<head>
<title>HTML Tutorial</title>
</head>

The title is shown in the browser\'s title bar',
          ),
        ),
        'code_snippet' => '<!DOCTYPE html>
<html>
<head>
  <title>My First Title</title>
</head>
<body>
  <p>The title of this document is visible in the browser tab above.</p>
</body>
</html>',
        'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        'video_explanation' => 'In this subtopic lesson, we cover HTML Page Title. Read the slides, review the code snippet, and click \'Open Sandbox Playground\' to complete the challenge validator checklist.',
      ),
      1 => 
      array (
        'title' => 'HTML Colors',
        'type' => 'ppt',
        'order' => 2,
        'ppt_slides' => 
        array (
          0 => 
          array (
            'title' => 'HTML COLORS',
            'content' => 'HTML colors are used to style text, backgrounds, and borders.

Colors can be defined using:
• Color names (e.g., Red, Blue)
• HEX (#ff0000)
• RGB (rgb(255,0,0))
• HSL (hsl(0,100%,50%))',
          ),
          1 => 
          array (
            'title' => 'COLOR APPLICATIONS',
            'content' => '• Text Color
• Background Color
• Border Color

<h1 style="background-color:yellow; border:2px solid Violet; color:white">Hello</h1>',
          ),
        ),
        'code_snippet' => '<!DOCTYPE html>
<html>
<body>
  <h1 style="background-color:tomato; color:white; border:2px solid dodgerblue;">Vibrant Colors</h1>
  <p style="color:mediumseagreen;">Styling content with custom inline color properties.</p>
</body>
</html>',
        'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        'video_explanation' => 'In this subtopic lesson, we cover HTML Colors. Read the slides, review the code snippet, and click \'Open Sandbox Playground\' to complete the challenge validator checklist.',
      ),
      2 => 
      array (
        'title' => 'HTML Links',
        'type' => 'ppt',
        'order' => 3,
        'ppt_slides' => 
        array (
          0 => 
          array (
            'title' => 'HTML LINKS',
            'content' => 'HTML links are hyperlinks.
You can click on a link and jump to another document.
When you move the mouse over a link, the mouse arrow will turn into a little hand.

Note: A link does not have to be text. A link can be an image or any other HTML element!',
          ),
          1 => 
          array (
            'title' => 'HTML LINKS - SYNTAX',
            'content' => 'The HTML <a> tag defines a hyperlink. It has the following syntax:
<a href="url">link text</a>

The <a> element’s key attribute is href, which specifies the destination, while the visible link text is what users click to navigate to the given URL.

<a href="https://www.w3schools.com/">Visit W3Schools.com!</a>',
          ),
          2 => 
          array (
            'title' => 'HTML LINKS - THE TARGET ATTRIBUTE',
            'content' => 'The target attribute can have one of the following values:
• _self - Default. Opens the document in the same window/tab as it was clicked
• _blank - Opens the document in a new window or tab
• _parent - Opens the document in the parent frame
• _top - Opens the document in the full body of the window

Use target="_blank" to open the linked document in a new browser window or tab:
<a href="https://www.w3schools.com/" target="_blank">Visit W3Schools!</a>',
          ),
          3 => 
          array (
            'title' => 'LINK TITLES',
            'content' => 'The title attribute specifies extra information about an element. The information is most often shown as a tooltip text when the mouse moves over the element.

<a href="https://www.w3schools.com/html/" title="Go to W3Schools HTML section">Visit our HTML Tutorial</a>',
          ),
        ),
        'code_snippet' => '<!DOCTYPE html>
<html>
<body>
  <p><a href="https://www.google.com" target="_blank" title="Goes to Google Search">Open Google in New Tab</a></p>
</body>
</html>',
        'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        'video_explanation' => 'In this subtopic lesson, we cover HTML Links. Read the slides, review the code snippet, and click \'Open Sandbox Playground\' to complete the challenge validator checklist.',
      ),
      3 => 
      array (
        'title' => 'HTML Images',
        'type' => 'ppt',
        'order' => 4,
        'ppt_slides' => 
        array (
          0 => 
          array (
            'title' => 'HTML IMAGES',
            'content' => 'The HTML <img> tag is used to display images on a webpage.
Images are linked, not directly embedded, and the tag serves as a placeholder.
It is an empty tag with no closing tag and only contains attributes.

The src attribute specifies the image file path.
The alt attribute provides alternative text for the image.

<img src="url" alt="alternatetext">',
          ),
          1 => 
          array (
            'title' => 'HTML IMAGES STYLE',
            'content' => 'Use the HTML <img> element to define an image
Use the HTML src attribute to define the URL or path of the image
Use the HTML alt attribute to define an alternate text for an image, if it cannot be displayed
Use the HTML width and height attributes or the CSS width and height properties to define the size of the image
Use the CSS float property to let the image float to the left or to the right

<p><img src="smiley.gif" alt="Smiley face" style="float:right;width:42px;height:42px;">
The image will float to the right of the text.</p>',
          ),
        ),
        'code_snippet' => '<!DOCTYPE html>
<html>
<body>
  <img src="https://www.w3schools.com/html/img_chania.jpg" alt="Chania Flowers" style="width:200px; height:auto; border-radius:8px;">
  <p>The image above uses width and height styles.</p>
</body>
</html>',
        'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        'video_explanation' => 'In this subtopic lesson, we cover HTML Images. Read the slides, review the code snippet, and click \'Open Sandbox Playground\' to complete the challenge validator checklist.',
      ),
      4 => 
      array (
        'title' => 'HTML Favicon',
        'type' => 'ppt',
        'order' => 5,
        'ppt_slides' => 
        array (
          0 => 
          array (
            'title' => 'HTML FAVICON',
            'content' => 'A favicon is a small image displayed next to the page title in the browser tab.
You can use any image you like as your favicon.
A favicon image is displayed to the left of the page title in the browser tab.
To add a favicon, place the image in your website’s root directory or inside an “images” folder within it.
A commonly used filename for a favicon is “favicon.ico”.',
          ),
          1 => 
          array (
            'title' => 'HTML FAVICON LINK',
            'content' => 'Next, add a <link> element to your "index.html" file, after the <title> element, like this:

<!DOCTYPE html>
<html>
<head>
<title>My Page Title</title>
<link rel="icon" type="image/x-icon" href="/images/favicon.ico">
</head>
<body>
<h1>This is a Heading</h1>
<p>This is a paragraph.</p>
</body>
</html>',
          ),
        ),
        'code_snippet' => '<!DOCTYPE html>
<html>
<head>
  <title>Favicon Example</title>
  <link rel="icon" type="image/x-icon" href="https://www.w3schools.com/html/favicon.ico">
</head>
<body>
  <p>The head section includes a link element pointing to the favicon file.</p>
</body>
</html>',
        'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        'video_explanation' => 'In this subtopic lesson, we cover HTML Favicon. Read the slides, review the code snippet, and click \'Open Sandbox Playground\' to complete the challenge validator checklist.',
      ),
    ),
    'quiz' => 
    array (
      'title' => 'Module 4 Assessment',
      'passing_score' => 4,
      'total_points' => 5,
      'questions' => 
      array (
        0 => 
        array (
          'question_text' => 'Which format is valid for HEX color?',
          'choices' => 
          array (
            0 => 'rgb(255,0,0)',
            1 => '#ff0000',
            2 => 'red(255)',
            3 => 'color(red)',
          ),
          'correct_answer' => '#ff0000',
        ),
        1 => 
        array (
          'question_text' => 'Which tag defines a hyperlink?',
          'choices' => 
          array (
            0 => '<link>',
            1 => '<href>',
            2 => '<a>',
            3 => '<url>',
          ),
          'correct_answer' => '<a>',
        ),
        2 => 
        array (
          'question_text' => 'Which tag displays images?',
          'choices' => 
          array (
            0 => '<image>',
            1 => '<img>',
            2 => '<pic>',
            3 => '<src>',
          ),
          'correct_answer' => '<img>',
        ),
        3 => 
        array (
          'question_text' => 'Common favicon file name?',
          'choices' => 
          array (
            0 => 'icon.png',
            1 => 'favicon.ico',
            2 => 'logo.jpg',
            3 => 'tab.png',
          ),
          'correct_answer' => 'favicon.ico',
        ),
        4 => 
        array (
          'question_text' => 'Which tag sets page title?',
          'choices' => 
          array (
            0 => '<title>',
            1 => '<head>',
            2 => '<meta>',
            3 => '<h1>',
          ),
          'correct_answer' => '<title>',
        ),
      ),
    ),
  ),
  4 => 
  array (
    'title' => 'Module 5: HTML Tables and Lists',
    'description' => 'Master structured data layouts by implementing ordered, unordered, and description lists, as well as complex tabular data structures using HTML tables.',
    'order' => 5,
    'lessons' => 
    array (
      0 => 
      array (
        'title' => 'HTML Lists',
        'type' => 'ppt',
        'order' => 1,
        'ppt_slides' => 
        array (
          0 => 
          array (
            'title' => 'UNORDERED HTML LIST',
            'content' => 'An unordered list begins with the <ul> tag, and each item is defined using the <li> tag.
By default, the items are displayed with bullet points (small black circles).

<ul>
<li>Coffee</li>
<li>Tea</li>
<li>Milk</li>
</ul>',
          ),
          1 => 
          array (
            'title' => 'ORDERED HTML LIST',
            'content' => 'An ordered list uses the <ol> tag, with each item defined by the <li> tag.
By default, the items are displayed with numbers.

<ol>
<li>Coffee</li>
<li>Tea</li>
<li>Milk</li>
</ol>',
          ),
          2 => 
          array (
            'title' => 'HTML DESCRIPTION LIST',
            'content' => 'A description list is a list of terms, with a description of each term.
The <dl> tag defines the description list, the <dt> tag defines the term (name), and the <dd> tag describes each term:

<dl>
<dt>Coffee</dt>
<dd>- black hot drink</dd>
<dt>Milk</dt>
<dd>- white cold drink</dd>
</dl>',
          ),
        ),
        'code_snippet' => '<!DOCTYPE html>
<html>
<body>
  <h3>Shopping List</h3>
  <ul>
    <li>Apples</li>
    <li>Bananas</li>
  </ul>
  <h3>ToDo List</h3>
  <ol>
    <li>Wake up</li>
    <li>Code HTML</li>
  </ol>
</body>
</html>',
        'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        'video_explanation' => 'In this subtopic lesson, we cover HTML Lists. Read the slides, review the code snippet, and click \'Open Sandbox Playground\' to complete the challenge validator checklist.',
      ),
      1 => 
      array (
        'title' => 'HTML Tables',
        'type' => 'ppt',
        'order' => 2,
        'ppt_slides' => 
        array (
          0 => 
          array (
            'title' => 'TABLE CELLS',
            'content' => 'Each table cell is defined by a <td> and a </td> tag.
td stands for table data.

<table>
<tr>
<td>Emil</td>
<td>Tobias</td>
<td>Linus</td>
</tr>
</table>',
          ),
          1 => 
          array (
            'title' => 'TABLE ROWS',
            'content' => 'Each table row starts with a <tr> and ends with a </tr> tag.
tr stands for table row.

<table>
<tr>
<td>Emil</td>
<td>Tobias</td>
<td>Linus</td>
</tr>
<tr>
<td>16</td>
<td>14</td>
<td>10</td>
</tr>
</table>',
          ),
          2 => 
          array (
            'title' => 'TABLE HEADER CELLS',
            'content' => 'When you need header cells in a table, use the <th> tag instead of <td>.
th stands for table header.

<table>
<tr>
<th>Person 1</th>
<th>Person 2</th>
<th>Person 3</th>
</tr>
</table>',
          ),
        ),
        'code_snippet' => '<!DOCTYPE html>
<html>
<body>
  <table border="1" style="border-collapse: collapse; width: 100%;">
    <tr>
      <th>First Name</th>
      <th>Age</th>
    </tr>
    <tr>
      <td>Emil</td>
      <td>16</td>
    </tr>
    <tr>
      <td>Tobias</td>
      <td>14</td>
    </tr>
  </table>
</body>
</html>',
        'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        'video_explanation' => 'In this subtopic lesson, we cover HTML Tables. Read the slides, review the code snippet, and click \'Open Sandbox Playground\' to complete the challenge validator checklist.',
      ),
    ),
    'quiz' => 
    array (
      'title' => 'Module 5 Assessment',
      'passing_score' => 4,
      'total_points' => 5,
      'questions' => 
      array (
        0 => 
        array (
          'question_text' => 'Which tag defines a table cell?',
          'choices' => 
          array (
            0 => '<tr>',
            1 => '<td>',
            2 => '<th>',
            3 => '<table>',
          ),
          'correct_answer' => '<td>',
        ),
        1 => 
        array (
          'question_text' => 'What does <tr> stand for?',
          'choices' => 
          array (
            0 => 'table record',
            1 => 'table range',
            2 => 'table row',
            3 => 'table render',
          ),
          'correct_answer' => 'table row',
        ),
        2 => 
        array (
          'question_text' => 'Which tag starts an unordered list?',
          'choices' => 
          array (
            0 => '<ol>',
            1 => '<ul>',
            2 => '<li>',
            3 => '<dl>',
          ),
          'correct_answer' => '<ul>',
        ),
        3 => 
        array (
          'question_text' => 'What is the default display of ordered list?',
          'choices' => 
          array (
            0 => 'bullet points',
            1 => 'symbols',
            2 => 'letters',
            3 => 'numbers',
          ),
          'correct_answer' => 'numbers',
        ),
        4 => 
        array (
          'question_text' => 'Which tag describes a term in description list?',
          'choices' => 
          array (
            0 => '<dd>',
            1 => '<dt>',
            2 => '<dl>',
            3 => '<li>',
          ),
          'correct_answer' => '<dd>',
        ),
      ),
    ),
  ),
  5 => 
  array (
    'title' => 'Module 6: Layout and Structure',
    'description' => 'Understand block-level versus inline elements, container tags like div and span, unique ID and class attributes, layout techniques, and the fundamentals of responsive web design.',
    'order' => 6,
    'lessons' => 
    array (
      0 => 
      array (
        'title' => 'HTML Block and Inline',
        'type' => 'ppt',
        'order' => 1,
        'ppt_slides' => 
        array (
          0 => 
          array (
            'title' => 'BLOCK-LEVEL ELEMENTS',
            'content' => 'Starts on a new line with automatic spacing (margin)
Occupies full available width
Common examples: <p> and <div>
<p> is used for paragraphs
<div> is used for sections or divisions
Both <p> and <div> are block-level elements

<p>Hello World</p>
<div>Hello World</div>',
          ),
          1 => 
          array (
            'title' => 'INLINE ELEMENTS',
            'content' => 'An inline element does not start on a new line.
An inline element only takes up as much width as necessary.
This is a <span> element inside a paragraph.

<span>Hello World</span>

Note: An inline element cannot contain a block-level element!',
          ),
          2 => 
          array (
            'title' => 'THE <SPAN> ELEMENT',
            'content' => '<span> is an inline container for parts of text or a document
It has no required attributes
Commonly uses style, class, and id

<p>My mother has <span style="color:blue; font-weight:bold;">blue</span> eyes and my father has <span style="color:darkolivegreen; font-weight:bold;">dark green</span> eyes.</p>',
          ),
        ),
        'code_snippet' => '<!DOCTYPE html>
<html>
<body>
  <div style="background-color:lightgrey; padding:10px;">
    <p>This is a block-level paragraph containing a <span style="color:red; font-weight:bold;">red inline span</span> element.</p>
  </div>
</body>
</html>',
        'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        'video_explanation' => 'In this subtopic lesson, we cover HTML Block and Inline. Read the slides, review the code snippet, and click \'Open Sandbox Playground\' to complete the challenge validator checklist.',
      ),
      1 => 
      array (
        'title' => 'HTML Div Container',
        'type' => 'ppt',
        'order' => 2,
        'ppt_slides' => 
        array (
          0 => 
          array (
            'title' => 'THE <DIV> ELEMENT',
            'content' => 'The <div> tag defines a division or section in an HTML document.
It is commonly used as a container for other HTML elements.
Helps organize content into groups.

<div style="background-color:black;color:white;padding:20px;">
<h2>London</h2>
<p>London is the capital city of England. </p>
</div>',
          ),
          1 => 
          array (
            'title' => 'DIV AS A CONTAINER',
            'content' => 'Used to group sections of a web page
Helps organize content

<div>
<h2>London</h2>
<p>London is the capital city of England.</p>
<p>London has over 9 million inhabitants.</p>
</div>',
          ),
          2 => 
          array (
            'title' => 'CENTER ALIGN A <DIV>',
            'content' => 'Use CSS margin: auto to center a div

<style>
div {
width: 300px;
margin: auto;
}
</style>',
          ),
          3 => 
          array (
            'title' => 'MULTIPLE <DIV> ELEMENTS',
            'content' => 'You can use many <div> containers on one page

<div>
<h2>London</h2>
</div>
<div>
<h2>Oslo</h2>
</div>
<div>
<h2>Rome</h2>
</div>',
          ),
          4 => 
          array (
            'title' => 'USING FLOAT',
            'content' => 'The float property positions elements horizontally

<style>
.mycontainer {
width: 100%;
overflow: auto;
}
.mycontainer div {
width: 33%;
float: left;
}
</style>',
          ),
          5 => 
          array (
            'title' => 'USING INLINE-BLOCK',
            'content' => 'Change display to inline-block

<style>
div {
width: 30%;
display: inline-block;
}
</style>

Removes line breaks and places divs side by side',
          ),
        ),
        'code_snippet' => '<!DOCTYPE html>
<html>
<body>
  <div style="background-color:lavender; padding:20px; text-align:center; max-width:300px; margin:auto;">
    <h2>My Div Card</h2>
    <p>Centered card-like block content.</p>
  </div>
</body>
</html>',
        'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        'video_explanation' => 'In this subtopic lesson, we cover HTML Div Container. Read the slides, review the code snippet, and click \'Open Sandbox Playground\' to complete the challenge validator checklist.',
      ),
      2 => 
      array (
        'title' => 'HTML Classes',
        'type' => 'ppt',
        'order' => 3,
        'ppt_slides' => 
        array (
          0 => 
          array (
            'title' => 'HTML CLASSES',
            'content' => 'Element is used as a container for other HTML elements.',
          ),
          1 => 
          array (
            'title' => 'WHAT IS CLASS ATTRIBUTE?',
            'content' => 'Used to connect HTML with CSS styles
Used by JavaScript to access and modify elements
Helps apply the same design to multiple elements
Note: The class name is case sensitive!

<h2 class="city main">London</h2>',
          ),
        ),
        'code_snippet' => '<!DOCTYPE html>
<html>
<head>
  <style>
    .highlight { background-color: gold; font-weight: bold; }
  </style>
</head>
<body>
  <p class="highlight">This paragraph is highlighted.</p>
  <span class="highlight">This span is also highlighted.</span>
</body>
</html>',
        'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        'video_explanation' => 'In this subtopic lesson, we cover HTML Classes. Read the slides, review the code snippet, and click \'Open Sandbox Playground\' to complete the challenge validator checklist.',
      ),
      3 => 
      array (
        'title' => 'HTML Id Attribute',
        'type' => 'ppt',
        'order' => 4,
        'ppt_slides' => 
        array (
          0 => 
          array (
            'title' => 'HTML ID',
            'content' => 'Element is used as a container for other HTML elements.',
          ),
          1 => 
          array (
            'title' => 'HTML ID UNIQUE',
            'content' => 'Each id must be used only once in a document
Used in CSS to apply specific styles
Used in JavaScript to access and modify elements
CSS syntax: #idName { }
Example: <h1> can use id="myHeader" to apply styles from #myHeader
id must have at least one character, cannot start with a number, and must not contain spaces

<h1 id="myHeader">My Header</h1>',
          ),
          2 => 
          array (
            'title' => 'DIFFERENCE BETWEEN CLASS AND ID',
            'content' => 'A class name can be used by multiple HTML elements, while an id name must only be used by one HTML element within the page

<!-- An element with a unique id -->
<h1 id="myHeader">My Cities</h1>

<!-- Multiple elements with same class -->
<h2 class="city">London</h2>
<p>London is the capital of England.</p>
<h2 class="city">Paris</h2>
<p>Paris is the capital of France.</p>',
          ),
        ),
        'code_snippet' => '<!DOCTYPE html>
<html>
<head>
  <style>
    #main-title { color: slateblue; text-decoration: underline; }
  </style>
</head>
<body>
  <h1 id="main-title">Unique Header</h1>
</body>
</html>',
        'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        'video_explanation' => 'In this subtopic lesson, we cover HTML Id Attribute. Read the slides, review the code snippet, and click \'Open Sandbox Playground\' to complete the challenge validator checklist.',
      ),
      4 => 
      array (
        'title' => 'HTML Layout Techniques',
        'type' => 'ppt',
        'order' => 5,
        'ppt_slides' => 
        array (
          0 => 
          array (
            'title' => 'HTML LAYOUT',
            'content' => 'Element is used as a container for other HTML elements.',
          ),
          1 => 
          array (
            'title' => 'HTML LAYOUT TECHNIQUES',
            'content' => 'There are four different techniques to create multicolumn layouts:
• CSS frameworks
• CSS float property
• CSS flexbox
• CSS grid',
          ),
        ),
        'code_snippet' => '<!DOCTYPE html>
<html>
<body>
  <header style="background-color: #333; color: white; padding: 10px; text-align: center;">
    <h2>My Website Layout</h2>
  </header>
  <p>Layouts structure content cleanly for the user.</p>
</body>
</html>',
        'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        'video_explanation' => 'In this subtopic lesson, we cover HTML Layout Techniques. Read the slides, review the code snippet, and click \'Open Sandbox Playground\' to complete the challenge validator checklist.',
      ),
      5 => 
      array (
        'title' => 'HTML Responsive Design',
        'type' => 'ppt',
        'order' => 6,
        'ppt_slides' => 
        array (
          0 => 
          array (
            'title' => 'HTML RESPONSIVE',
            'content' => 'ABOUT CREATING WEB PAGES THAT LOOK GOOD ON ALL DEVICES!',
          ),
          1 => 
          array (
            'title' => 'WHAT IS RESPONSIVE WEB DESIGN?',
            'content' => 'Responsive Web Design (RWD) uses HTML and CSS
Automatically adjusts website layout

Works on:
• Desktops
• Tablets
• Mobile Phones',
          ),
          2 => 
          array (
            'title' => 'PURPOSE OF RESPONSIVE DESIGN',
            'content' => 'Improves user experience
Makes websites accessible on all devices

Adjusts:
• Size
• Layout
• Visibility of elements',
          ),
          3 => 
          array (
            'title' => 'SETTING THE VIEWPORT',
            'content' => 'Add this meta tag to all web pages:

<meta name="viewport" content="width=device-width, initial-scale=1.0">

Controls page size and scaling
Essential for mobile-friendly design',
          ),
          4 => 
          array (
            'title' => 'RESPONSIVE IMAGES',
            'content' => 'Images adjust to fit screen size
Using width:

<img src="img_girl.jpg" style="width:100%;">

Can scale bigger than original',
          ),
        ),
        'code_snippet' => '<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
  <h2>Responsive Page</h2>
  <p>Resize the browser window to see how scaling adapts correctly.</p>
</body>
</html>',
        'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
        'video_explanation' => 'In this subtopic lesson, we cover HTML Responsive Design. Read the slides, review the code snippet, and click \'Open Sandbox Playground\' to complete the challenge validator checklist.',
      ),
    ),
    'quiz' => 
    array (
      'title' => 'Module 6 Assessment',
      'passing_score' => 4,
      'total_points' => 5,
      'questions' => 
      array (
        0 => 
        array (
          'question_text' => 'Which element is a block-level element?',
          'choices' => 
          array (
            0 => '<span>',
            1 => '<a>',
            2 => '<p>',
            3 => '<img>',
          ),
          'correct_answer' => '<p>',
        ),
        1 => 
        array (
          'question_text' => 'What does an inline element NOT do?',
          'choices' => 
          array (
            0 => 'Takes full width',
            1 => 'Starts on new line',
            2 => 'Uses style',
            3 => 'Contains text',
          ),
          'correct_answer' => 'Starts on new line',
        ),
        2 => 
        array (
          'question_text' => 'What is <div> used for?',
          'choices' => 
          array (
            0 => 'Sections or divisions',
            1 => 'Links',
            2 => 'Images',
            3 => 'Lists',
          ),
          'correct_answer' => 'Sections or divisions',
        ),
        3 => 
        array (
          'question_text' => 'What is class used for?',
          'choices' => 
          array (
            0 => 'Tables',
            1 => 'Connecting HTML with CSS',
            2 => 'Images',
            3 => 'Links',
          ),
          'correct_answer' => 'Connecting HTML with CSS',
        ),
        4 => 
        array (
          'question_text' => 'What does responsive design do?',
          'choices' => 
          array (
            0 => 'Adds color',
            1 => 'Adds Links',
            2 => 'Adds images',
            3 => 'Adjusts layout automatically',
          ),
          'correct_answer' => 'Adjusts layout automatically',
        ),
      ),
    ),
  ),
);

        // ─── 4. SEED GENERATOR LOOP ──────────────────────────────────────────
        foreach ($courseData as $mIndex => $mItem) {
            $this->command->info("Seeding Module: {$mItem['title']}");

            // Create Module
            $module = Module::create([
                'teacher_id'  => $teacher->id,
                'title'       => $mItem['title'],
                'description' => $mItem['description'],
                'order'       => $mItem['order'] ?? ($mIndex + 1),
                'is_active'   => true,
                'is_locked'   => false,
            ]);

            // Seed Lessons for this Module
            foreach ($mItem['lessons'] as $lItem) {
                $pdfMapping = [
                    // Module 1
                    'HTML Introduction' => ['folder' => 'solismodule', 'path' => 'module 1/Module 1 HTML Introduction.pdf'],
                    'HTML Home Basics' => ['folder' => 'solismodule', 'path' => 'module 1/Module 1 HTML HOME.pdf'],
                    'HTML Editors Guide' => ['folder' => 'solismodule', 'path' => 'module 1/Module 1 HTML Editors.pdf'],
                    // Module 2
                    'HTML Basic Document Examples' => ['folder' => 'solismodule', 'path' => 'module 2/MODULE 2  HTML Documents.pdf'],
                    'HTML Elements & Nested Structures' => ['folder' => 'solismodule', 'path' => 'module 2/Module 2 HTML Elements.pdf'],
                    'HTML Attributes & Metadata' => ['folder' => 'solismodule', 'path' => 'module 2/Module 2 HTML Attributes.pdf'],
                    // Module 3
                    'HTML Headings (h1 to h6)' => ['folder' => 'solismodule', 'path' => 'module 3/MODULE 3 HTML Headings.pdf'],
                    'HTML Paragraphs & Spacing' => ['folder' => 'solismodule', 'path' => 'module 3/MODULE 3 HTML Paragraphs.pdf'],
                    'HTML CSS Styling Properties' => ['folder' => 'solismodule', 'path' => 'module 3/MODULE 3 HTML Styles.pdf'],
                    'HTML Text Formatting Options' => ['folder' => 'solismodule', 'path' => 'module 3/MODULE 3 HTML Text Formatting.pdf'],
                    'HTML Quotations & Citations' => ['folder' => 'solismodule', 'path' => 'module 3/MODULE 3 HTML Quotations.pdf'],
                    'HTML Comments Best Practices' => ['folder' => 'solismodule', 'path' => 'module 3/MODULE 3 HTML Comments.pdf'],
                    // Module 4
                    'HTML Page Title' => ['folder' => 'magnayemodule', 'path' => 'module 4/Module 4 HTML PAGE TITLE.pdf'],
                    'HTML Colors' => ['folder' => 'magnayemodule', 'path' => 'module 4/Module 4 HTML COLORS.pdf'],
                    'HTML Links' => ['folder' => 'magnayemodule', 'path' => 'module 4/Module 4 HTML LINKS.pdf'],
                    'HTML Images' => ['folder' => 'magnayemodule', 'path' => 'module 4/Module 4 HTML IMAGES.pdf'],
                    'HTML Favicon' => ['folder' => 'magnayemodule', 'path' => 'module 4/Module 4 HTML FAVICON.pdf'],
                    // Module 5
                    'HTML Lists' => ['folder' => 'magnayemodule', 'path' => 'module 5/Module 5 HTML LISTS.pdf'],
                    'HTML Tables' => ['folder' => 'magnayemodule', 'path' => 'module 5/Module 5 HTML TABLES.pdf'],
                    // Module 6
                    'HTML Block and Inline' => ['folder' => 'magnayemodule', 'path' => 'module 6/Module 6 HTML LAYOUT AND STRUCTURE.pdf'],
                    'HTML Div Container' => ['folder' => 'magnayemodule', 'path' => 'module 6/Module 6 HTML DIV.pdf'],
                    'HTML Classes' => ['folder' => 'magnayemodule', 'path' => 'module 6/Module 6 HTML CLASSES.pdf'],
                    'HTML Id Attribute' => ['folder' => 'magnayemodule', 'path' => 'module 6/Module 6 HTML ID.pdf'],
                    'HTML Layout Techniques' => ['folder' => 'magnayemodule', 'path' => 'module 6/Module 6 HTML LAYOUT.pdf'],
                    'HTML Responsive Design' => ['folder' => 'magnayemodule', 'path' => 'module 6/Module 6 HTML RESPONSIVE.pdf'],
                ];

                $filePath = null;
                $lessonType = $lItem['type'] ?? 'ppt';
                $title = $lItem['title'];

                if (isset($pdfMapping[$title])) {
                    $mapping = $pdfMapping[$title];
                    $srcFile = base_path($mapping['folder'] . '/' . $mapping['path']);
                    if (file_exists($srcFile)) {
                        $destDir = public_path('coursework_pdfs');
                        if (!file_exists($destDir)) {
                            mkdir($destDir, 0755, true);
                        }
                        $sanitizedName = strtolower(preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $title)) . '.pdf';
                        $destFile = $destDir . '/' . $sanitizedName;
                        copy($srcFile, $destFile);
                        $filePath = 'coursework_pdfs/' . $sanitizedName;
                        $lessonType = 'pdf';
                    }
                }

                Lesson::create([
                    'module_id'               => $module->id,
                    'title'                   => $title,
                    'type'                    => $lessonType,
                    'file_path'               => $filePath,
                    'video_url'               => $lItem['video_url'] ?? null,
                    'video_explanation'       => $lItem['video_explanation'] ?? null,
                    'ppt_slides'              => $lItem['ppt_slides'] ?? [],
                    'video_thumbnail'         => $lItem['video_thumbnail'] ?? null,
                    'code_snippet'            => $lItem['code_snippet'] ?? null,
                    'code_explanation_video'  => $lItem['code_explanation_video'] ?? null,
                ]);
            }

            // Create and Seed Module Quiz / Questions
            if (isset($mItem['quiz'])) {
                $qItem = $mItem['quiz'];
                $quiz = Quiz::create([
                    'module_id'     => $module->id,
                    'title'         => $qItem['title'],
                    'type'          => 'module_assessment',
                    'passing_score' => $qItem['passing_score'],
                    'total_points'  => $qItem['total_points'],
                    'randomize'     => true,
                    'show_answers'  => false,
                ]);

                foreach ($qItem['questions'] as $qn) {
                    $correctIndex = array_search($qn['correct_answer'], $qn['choices']);
                    $letters = ['a', 'b', 'c', 'd'];
                    $correctLetter = ($correctIndex !== false) ? $letters[$correctIndex] : 'a';

                    Question::create([
                        'quiz_id'        => $quiz->id,
                        'question_text'  => $qn['question_text'],
                        'choice_a'       => $qn['choices'][0] ?? '',
                        'choice_b'       => $qn['choices'][1] ?? '',
                        'choice_c'       => $qn['choices'][2] ?? '',
                        'choice_d'       => $qn['choices'][3] ?? '',
                        'correct_answer' => $correctLetter,
                        'points'         => 1,
                    ]);
                }
            }
        }

        // ─── 5. SEED COMPREHENSIVE FINAL EXAM ──────────────────────────────────
        $this->command->info('Seeding Comprehensive Final Exam...');
        $finalQuizData = array (
  'title' => 'Final Comprehensive Certification Quiz',
  'passing_score' => 25,
  'total_points' => 30,
  'questions' => 
  array (
    0 => 
    array (
      'question_text' => 'What is the correct HTML structure?',
      'choices' => 
      array (
        0 => '<html><head></head><body></body></html>',
        1 => '<head><html><body></body></html></head>',
        2 => '<body><html><head></head></html></body>',
        3 => '<html><body></body><head></head></html>',
      ),
      'correct_answer' => '<html><head></head><body></body></html>',
    ),
    1 => 
    array (
      'question_text' => 'Write the code that correctly displays "Hello World" as a paragraph.',
      'choices' => 
      array (
        0 => '<para>Hello World</para>',
        1 => '<p>Hello World</p>',
        2 => '<text>Hello World</text>',
        3 => '<h1>Hello World</h1>',
      ),
      'correct_answer' => '<p>Hello World</p>',
    ),
    2 => 
    array (
      'question_text' => 'What will this code display?

```html
<h1>Title</h1>
<p>Content</p>
```',
      'choices' => 
      array (
        0 => 'Title (small) / Content (large)',
        1 => 'Title (large) / Content (normal)',
        2 => 'Title and Content (both normal)',
        3 => 'Title and Content (both large)',
      ),
      'correct_answer' => 'Title (large) / Content (normal)',
    ),
    3 => 
    array (
      'question_text' => 'Which tag is used for the MAIN heading (most important)?',
      'choices' => 
      array (
        0 => '<h6>',
        1 => '<head>',
        2 => '<h1>',
        3 => '<header>',
      ),
      'correct_answer' => '<h1>',
    ),
    4 => 
    array (
      'question_text' => 'What is the correct code for a line break?',
      'choices' => 
      array (
        0 => '<br>',
        1 => '<lb>',
        2 => '<break>',
        3 => '<newline>',
      ),
      'correct_answer' => '<br>',
    ),
    5 => 
    array (
      'question_text' => 'Which tag creates BOLD text (visual only, no semantic meaning)?',
      'choices' => 
      array (
        0 => '<strong>',
        1 => '<b>',
        2 => '<bold>',
        3 => '<em>',
      ),
      'correct_answer' => '<b>',
    ),
    6 => 
    array (
      'question_text' => 'Which tag creates ITALIC text with emphasis for screen readers?',
      'choices' => 
      array (
        0 => '<i>',
        1 => '<italic>',
        2 => '<em>',
        3 => '<slanted>',
      ),
      'correct_answer' => '<em>',
    ),
    7 => 
    array (
      'question_text' => 'What will this code display?

```html
<p style="color:red;">Stop</p>
```',
      'choices' => 
      array (
        0 => 'Blue text saying "Stop"',
        1 => 'Red text saying "Stop"',
        2 => 'Green text saying "Stop"',
        3 => 'Black text saying "Stop"',
      ),
      'correct_answer' => 'Red text saying "Stop"',
    ),
    8 => 
    array (
      'question_text' => 'Which code centers text?',
      'choices' => 
      array (
        0 => '<p style="align:center;">Text</p>',
        1 => '<p style="text-align:center;">Text</p>',
        2 => '<p center>Text</p>',
        3 => '<p align="center">Text</p>',
      ),
      'correct_answer' => '<p style="text-align:center;">Text</p>',
    ),
    9 => 
    array (
      'question_text' => 'Which code displays E = mc² (squared) correctly?',
      'choices' => 
      array (
        0 => 'E = mc<sub>2</sub>',
        1 => 'E = mc<up>2</up>',
        2 => 'E = mc<sup>2</sup>',
        3 => 'E = mc^2',
      ),
      'correct_answer' => 'E = mc<sup>2</sup>',
    ),
    10 => 
    array (
      'question_text' => 'What will this code display?

```html
<p>Hello <mark>World</mark></p>
```',
      'choices' => 
      array (
        0 => 'Hello World (normal)',
        1 => 'Hello World (with World highlighted yellow)',
        2 => 'Hello World (bold)',
        3 => 'Hello World (italic)',
      ),
      'correct_answer' => 'Hello World (with World highlighted yellow)',
    ),
    11 => 
    array (
      'question_text' => 'Which code creates a small text?',
      'choices' => 
      array (
        0 => '<tiny>small</tiny>',
        1 => '<small>small</small>',
        2 => '<mini>small</mini>',
        3 => '<size="small">small</size>',
      ),
      'correct_answer' => '<small>small</small>',
    ),
    12 => 
    array (
      'question_text' => 'Look at this code. What is wrong?

```html
<html>
<body>
<title>My Page</title>
<h1>Welcome</h1>
</body>
</html>
```',
      'choices' => 
      array (
        0 => 'Missing <head> tag for <title>',
        1 => '<h1> should be inside <head>',
        2 => '<body> is misspelled',
        3 => 'Nothing is wrong',
      ),
      'correct_answer' => 'Missing <head> tag for <title>',
    ),
    13 => 
    array (
      'question_text' => 'Which code creates a comment in HTML?',
      'choices' => 
      array (
        0 => '// This is a comment',
        1 => '/* This is a comment */',
        2 => '/ This is a comment /',
        3 => '<!-- This is a comment -->',
      ),
      'correct_answer' => '<!-- This is a comment -->',
    ),
    14 => 
    array (
      'question_text' => 'What will this code display?

```html
<h2 style="font-size:50px;">Big Text</h2>
```',
      'choices' => 
      array (
        0 => 'Normal heading size',
        1 => 'Extra large heading (50 pixels)',
        2 => 'Small heading',
        3 => 'No text displays',
      ),
      'correct_answer' => 'Extra large heading (50 pixels)',
    ),
    15 => 
    array (
      'question_text' => 'Which tag pair is CORRECT for subscript?',
      'choices' => 
      array (
        0 => '<down>text</down>',
        1 => '<sub>text</sub>',
        2 => '<sup>text</sup>',
        3 => '<low>text</low>',
      ),
      'correct_answer' => '<sub>text</sub>',
    ),
    16 => 
    array (
      'question_text' => 'What is the correct way to save an HTML file?',
      'choices' => 
      array (
        0 => 'document.txt',
        1 => 'page.doc',
        2 => 'index.html',
        3 => 'home.exe',
      ),
      'correct_answer' => 'index.html',
    ),
    17 => 
    array (
      'question_text' => 'Which attribute adds styling to an element?',
      'choices' => 
      array (
        0 => 'class',
        1 => 'style',
        2 => 'css',
        3 => 'font',
      ),
      'correct_answer' => 'style',
    ),
    18 => 
    array (
      'question_text' => 'What will this code display?

```html
<p>Price: <del>$100</del> <ins>$80</ins></p>
```',
      'choices' => 
      array (
        0 => 'Price: $100 $80',
        1 => 'Price: $100 crossed out, and $80 underlined',
        2 => 'Price: $80 only',
        3 => 'Price: $100 only',
      ),
      'correct_answer' => 'Price: $100 crossed out, and $80 underlined',
    ),
    19 => 
    array (
      'question_text' => 'Which code creates the largest heading?',
      'choices' => 
      array (
        0 => '<h1>Title</h1>',
        1 => '<h2>Title</h2>',
        2 => '<h6>Title</h6>',
        3 => '<heading>Title</heading>',
      ),
      'correct_answer' => '<h1>Title</h1>',
    ),
    20 => 
    array (
      'question_text' => 'What is the correct HTML for a paragraph with blue text?',
      'choices' => 
      array (
        0 => '<p style="blue">Text</p>',
        1 => '<p color="blue">Text</p>',
        2 => '<p style="color:blue;">Text</p>',
        3 => '<p font="blue">Text</p>',
      ),
      'correct_answer' => '<p style="color:blue;">Text</p>',
    ),
    21 => 
    array (
      'question_text' => 'Which tag is used for a short inline quotation (adds quotes automatically)?',
      'choices' => 
      array (
        0 => '<quote>',
        1 => '<blockquote>',
        2 => '<q>',
        3 => '<cite>',
      ),
      'correct_answer' => '<q>',
    ),
    22 => 
    array (
      'question_text' => 'What will this code display?

```html
<body bgcolor="yellow">
<h1>Hello</h1>
</body>
```',
      'choices' => 
      array (
        0 => 'White page with "Hello"',
        1 => 'Yellow page with "Hello"',
        2 => 'Black page with "Hello"',
        3 => 'Error message',
      ),
      'correct_answer' => 'Yellow page with "Hello"',
    ),
    23 => 
    array (
      'question_text' => 'Which code creates emphasized text (usually italic)?',
      'choices' => 
      array (
        0 => '<strong>',
        1 => '<b>',
        2 => '<mark>',
        3 => '<em>',
      ),
      'correct_answer' => '<em>',
    ),
    24 => 
    array (
      'question_text' => 'What does HTML stand for?',
      'choices' => 
      array (
        0 => 'Hyper Text Markup Language',
        1 => 'Home Tool Markup Language',
        2 => 'Hyperlinks Text Mark Language',
        3 => 'High Tech Modern Language',
      ),
      'correct_answer' => 'Hyper Text Markup Language',
    ),
    25 => 
    array (
      'question_text' => 'Who invented HTML?',
      'choices' => 
      array (
        0 => 'Bill Gates',
        1 => 'Mark Zuckerberg',
        2 => 'Tim Berners-Lee',
        3 => 'Steve Jobs',
      ),
      'correct_answer' => 'Tim Berners-Lee',
    ),
    26 => 
    array (
      'question_text' => 'What year was HTML5 released?',
      'choices' => 
      array (
        0 => '2008',
        1 => '2010',
        2 => '2014',
        3 => '2018',
      ),
      'correct_answer' => '2014',
    ),
    27 => 
    array (
      'question_text' => 'Which tag contains metadata (information about the page)?',
      'choices' => 
      array (
        0 => '<body>',
        1 => '<footer>',
        2 => '<head>',
        3 => '<main>',
      ),
      'correct_answer' => '<head>',
    ),
    28 => 
    array (
      'question_text' => 'What is the correct file extension for an HTML file?',
      'choices' => 
      array (
        0 => '.txt',
        1 => '.html',
        2 => '.doc',
        3 => '.exe',
      ),
      'correct_answer' => '.html',
    ),
    29 => 
    array (
      'question_text' => 'Which browser is built into Windows?',
      'choices' => 
      array (
        0 => 'Chrome',
        1 => 'Firefox',
        2 => 'Edge',
        3 => 'Safari',
      ),
      'correct_answer' => 'Edge',
    ),
  ),
);
        
        $finalQuiz = Quiz::create([
            'module_id'     => null, // Scoped to the entire coursework
            'title'         => $finalQuizData['title'],
            'type'          => 'final_exam',
            'passing_score' => $finalQuizData['passing_score'],
            'total_points'  => $finalQuizData['total_points'],
            'randomize'     => true,
            'show_answers'  => false,
        ]);

        foreach ($finalQuizData['questions'] as $qn) {
            $correctIndex = array_search($qn['correct_answer'], $qn['choices']);
            $letters = ['a', 'b', 'c', 'd'];
            $correctLetter = ($correctIndex !== false) ? $letters[$correctIndex] : 'a';

            Question::create([
                'quiz_id'        => $finalQuiz->id,
                'question_text'  => $qn['question_text'],
                'choice_a'       => $qn['choices'][0] ?? '',
                'choice_b'       => $qn['choices'][1] ?? '',
                'choice_c'       => $qn['choices'][2] ?? '',
                'choice_d'       => $qn['choices'][3] ?? '',
                'correct_answer' => $correctLetter,
                'points'         => 1,
            ]);
        }

        $this->command->info('RealCourseContentSeeder execution complete!');
    }
}
