# NetVOD : Rouyer Hugolin - Los Melissandre - Gallion Laura - Trieu Zhi-Sheng

NetVOD is a streaming platform, you can watch your favourite video for free, just enjoy and relax on our application! NetVOD has a navigation menu to browse the website. You can return to the Home page, signup, login, or access the catalogue. If you are logged in, you can go to your profile page.

## Installation

Execute the following command to install the project:

```bash
php composer.phar install
```

Set up the database "netvod" and use the sql file "sql/netvod.sql" to create the tables.

## Features

### Login / Inscription

If you start the web application, you can log in to your account or create a new one if you don't have one.
To log in to your account, you have to enter your email and your password.
To create a new account, you need an email and a password for the account. After that, you will receive an email to activate your account.

### Forgot Password

If you forgot your password, you could reset it by clicking on the link "Mot de passe oublié" on the login page. When you click on the button, it will ask your email to give you a link to a page where you can change your password. After you put in a new password and submit it, you have changed your password successfully.

### Access to the catalogue

After you are logged in, click on the button “Afficher le catalogue” to access at the catalogue. You can filter or order the catalogue by category, keywords, type and public type.

### Sort the catalogue by key-words

At the top of the catalogue, you can sort the catalogue by keywords. For this, click in the text area and enter your key-word

### Sort by alphabetical order

You have to be connected to access the catalogue. When you access the catalogue, you have a scrolling menu “Trier par titre alphabétique”. You choose, what type of sort you want.
Then click on the button “trier”, and you find what you sort by.

### Sort by genre

You have to be connected to access the catalogue. When you access the catalogue, you have a scrolling menu “selectionner un genre”.
You can decide a genre that you want to see that exists in our database. Then submit with the button “filter”. You can combine that with the functionality of the selection of the public.

### Sort by public

You have to be connected to access the catalogue. When you access the catalogue, you have a scrolling menu “selectionner un public”.
You can decide on a category of age. Then submit with the button “filter”. You can combine that with the functionality of the selection by genre.

### Access to a series

Click on a series for access to it. After, you can see the details of the series (name, date, description, rating, comments, etc ...). You can also choose an episode.

### Choose an episode

If you click on an episode, you can see the details of the episode (name, description) and you can see the video. Moreover, the latter is added to the watching list.

### Add a comment

You can also add a comment and a rating to a series or an episode. For this, enter your comment, and your rating and click on "Ajouter un commentaire".

### The watched list

When we are watching the last episode of the series, the application moves the series to the list of finished series.

### Home Page

On the home page "Accueil", when you do not register, just show “Bienvenue Dans la version wish de Netflix !”. When you are connected, you can see your email. When you go to the catalogue you can add a series to a liked list, it will show on your home page. You can also put a series in your watched list when you check a series, and you didn't watch the entire series. And if you complete a series, it would put automatically in your watching list.

### Profile

Only if you are connected, can you access your profile page.
On the profile page "Mon Profil", You can see that you can change your surname, your name and your favourite type of series. When you submit it, it will be registered in our database, and you can change it at any time you want. There is also a disconnect button if you want to log out of your account.
