Optimizations
=============

Javascript
----------

The webpack consolidade all javascript stuff into a single javascript file called app.js.
It means that all the libraries like jQuery, bootstrap and Axios will be inside that file that can get really big.

We can instruct the javascript compiler to group vendor packages into a bundle (a separate javascript file) so the browsers won't need to re-download stuff like jquery or bootstrap's javascript or the axios library.
This file will change only if we upgrade the vendor libraries.

To enable this feature, add the following line to the `webpack.mix.js` after mix.sass line:

```
.extract(['axios', 'bootstrap', 'jquery', 'lodash', 'popper.js', 'vue'])
```

Then we need to adjust the load of javacript files in our template:

```html
<script src="/js/manifest.js"></script>
<script src="/js/vendor.js"></script>
<script src="/js/app.js"></script>
```

This will also reduce the compilation time a lot!
