API
===

For the API we'll use Laravel's Passport package. Instalation instructions [here](https://laravel.com/docs/5.8/passport#installation).

After following the default instalation instructions, we can test the API from javascript.

Open the `resources/js/app.js` file and add the following code to the bottom of it and save:

```
window.axios.get('/api/user').then(data => {
    console.log(data);
});
```

Then in a terminal, execute the command bellow in the root folder to compile all the assets (CSS and JS):

```
npm run dev
```

Alternatively, you keep watching for file changes and auto-compile the assets.
```
npm run watch-poll
```

Take a look at the [Optimization tips](optimizations.md) to reduce compile time.

After compilation is successful reload your browser and have a look at the developer console. You should be able to see the response from the API containing the current user data. 


API Modeling
------------

