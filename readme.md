I like to code, especially code which presents things like web pages, and in particular I like to write code that in turn writes code. I like to do systems admin and configuration. I like to draw and write fiction as well, so it occurred to me that an application to share comic books or other sequential documents created from my (and other's) content would be useful, and certainly fun to write. That is the impetus for Storybook.

Storybook Comic Book Builder is an accessible Content Creator Application that in turn creates accessible documents. We have set requirements for the Builder that the comics or documents that it makes
     ~ use a mobile-first responsive design
     ~ are very quick to load
     ~ are accessible by WCAG guidelines
     ~ have semantic content and logical syntax
     ~ are easy to navigate using only the keyboard
     ~ support GIF or WebP animations and MP3 audio content
     ~ are portable to run on various media (eg thumb drives)

The logic and code that realizes the implementation of the first two requirements listed for the created documents, that they be a mobile-first responsive design and quick to load, is a specific part of the package that makes it novel so far as I have been able to determine. This next is an outline of the considerations and the approach to meeting the first two requirements:
I. why mobile-first responsive design? sheer numbers of audience devices
II. Intro and rationale
     A. responsive design versus adaptive design, definitions and distinctions
     B. the HTML/CSS image "srcset" concept as a method of adaptive design. the benefits of different image formats.
     C. a perceived rather serious flaw in the "srcset" method and its presentation of images. srcset selects images by width, if the image is taller than the display/viewport size it will be cropped
     D. Javascript used to realize responsive design by scaling images first chosen through the browser srcset. the javascript scales the images to fit within the viewport while maintaining the image aspect ratio
III. Explain the realization by exposing relevant portions of the code
    A. synopsis of the srcset construct for image selection
          i. the basic browser srcset implementation, how it works and why it doesn't
          ii. how the builder creates the srcset for each comic book image
    B. how we use Javascript to modify the image's HTML srcset and other attributes
    C. how we then use the Javascript to scale the srcset selection to fit within the viewport while maintaining the aspect ratio.
IV. Explain how this method coincidentally and synergistically also substantially increases download speeds by minimizing content file sizes.

Our example documents are primarily accessible web comic books. The Storybook app and the comics it creates both satisfy the WebAIM evaluation test for Web Content Accessibilty Guidelines (WCAG) which seems a fairly good starting point for such testing. This implies that they are largely accessible to challenged users.

One aspect of accessibility is Semantic Content, some hierarchy that assistive technologies can parse for the user. As it happens search engines as well as users can benefit from this technique, and so this should also favorably influence page SEO ranking.

Another aspect of accessibility is the navigability of the site, and we want our documents to be navigable by keyboard without the use of a mouse.

Storybook was initially set up as a Facebook app with a FB page at https://www.facebook.com/Storybook-Comic-Book-Builder-112113734045065 and as such it uses the FB Open Graph API to logon and authenticate users. For FB users the app facilitates "Liking" the Storybook page and it also facilitates "Sharing" the comic to FB. The Facebook Login Code has been removed from this repo, it is included in Logins repo shared on our GitHub page. The home site for the domain is https://syntheticreality.net which runs a short CSS animation (which satisfies the WebAIM evaluation for accessibility) before it gives you the option to enter the Storybook Comic Book gallery. A direct link to the Comics Gallery page is provided by https://syntheticreality.net/Comics/Comics.php and the menu section of the gallery page has a link to the Builder application.

Besides creating and then hosting comics, Storybook offers users the opportunity to download a ZIP archive of their comic that can be viewed elsewhere. Storybook uses HTML5, CSS3, Javascript, mySQL, and PHP to build and host comics on the app site, however the comics or documents that it creates only use HTML, CSS, and Javascript so the downloaded comic is very portable. Copies of the comic could easily be handed out on USB thumb drives for example. The comics use responsive design to support various device screen sizes, and the app and comics also leverage the Bootstrap framework and jQuery for attractive dynamic content presentation.

The image ScreenShot376.JPG presents the overall folder and file structure of the Storybook app. You can see that the referenced folders are physically at the same level as the htdocs webroot folder. Some are referenced through an alias so that they appear as subfolders under the htdocs folder to the app's HTML, and they may also be referenced by their physical or Linux file structures. Some are referenced by the PHP scripts only as filesystem locations or folders. In particular the folders named includes, uploads, session2DB are filesystem folders while the folders Storybook, Comics, ComicsUser and Facebook are all usable as subfolders beneath the /htdocs root.

Storybook presents as a gallery of comic books shown by the script Comics.php within the ./Comics/htdocs folder, and the builder is launched from the gallery page menu. The launch invokes a PHP script named OauthPortal.php within a folder aliased as a subfolder under htdocs, ./Storybook/htdocs. This script in turn uses calls to the Facebook API in the ./Facebook folder. If the script processes a successful Facebook logon it saves the new user into a database managed by the ComicsUser.class.php script within the ./ComicsUser folder and it offers to continue the builder, which it will do by launching the script within the same folder named index.php. The index.php script presents a dialog requesting various data about the comic being created, for example the comic title and its author among other information. Each item is processed by its own PHP handler script, and all of these handlers are also in the same ./Storybook/htdocs/ folder. Two of the handlers invoked by index.php are each used to select and upload an image, and to do that they each further invoke an imgUploader.php script to process those uploads whereupon they return to index.php.

Most of the data gathered by index.php centers on content used to populate the card that represents each comic in the gallery. Once this data has begun to be gathered, index.php will offer the user an option to continue the builder. Each requested value or piece of data may be required or optional, and each item should be considered with some care. When the user is finally satisfied with their inputs they should save their configuration as offered by the script before continuing the builder.

The next steps in the builder gather content to populate the actual comic itself. The user selects and then uploads this content, for example the page images, through following a sequence of dialog pages. Each dialog will invoke the imgUploader.php or the txtUploader.php script as required. Some of the inputs are nominally required, others are opional. Some of the information, image filenames for example, is gathered into a database managed by the ComicImages.class.php script within the ./includes folder. This data will be used in constructing the comic. After all of the sequential dialog pages have been processed or skipped the builder will finally launch the Yield.php script from within the ./Storybook/htdocs folder.

If Yield.php finds everything acceptable it will offer to create the comic book, and if the option is chosen Yield will launch the makeComic.php script that will parse the database and uploaded contents to create the actual comic book html and it will also invoke some other scripts to make and download a ZIP archive of the comic. An entry for the comic is made in the database managed by the ComicsUser.class.php script within the ./ComicsUser/htdocs folder. An opportunity is presented to easily "Share" the comic to FB and a card for the new comic is added to the gallery. Once the comic has been created Yield.php will launch the comic after a timeout.

The example code shows three documents in the ./Comics folder, two comics and a "Storybook Step By Step" user guide. They were all created by the Storybook app from user uploaded content, and you can see how the content is organized. There is also a folder named ExampleComicsContentSources which contains the local content that was selected and uploaded to create each document.

Ideas and suggestions are always welcome.

Added updates to files in the Storybook folder relative to feature additions to the builder. The changes add the backend to select fonts for headings versus body text, and the ability to add semantic tags, eg h1 or h3, to the caption text. This comic demos these feature changes, a scifi Bible story. https://syntheticreality.net/Comic/DisappearingAct.html

Added a "Font Chooser" that allows a user to select a Headings font and a Paprgraph font specification for the caption panels. The chooser also allows the selection of the caption panel background color.
