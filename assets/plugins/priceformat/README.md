# Jquery-Price-Format [![license](https://img.shields.io/github/license/flaviosilveira/Jquery-Price-Format.svg)](https://github.com/flaviosilveira/Jquery-Price-Format/blob/master/LICENSE) [![GitHub issues](https://img.shields.io/github/issues/flaviosilveira/Jquery-Price-Format.svg)](https://github.com/flaviosilveira/Jquery-Price-Format/issues) [![Codacy Badge](https://api.codacy.com/project/badge/Grade/4e3d85321e8741d194d1fcf993dc0352)](https://www.codacy.com/app/flavioaugustosilveira/Jquery-Price-Format?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=flaviosilveira/Jquery-Price-Format&amp;utm_campaign=Badge_Grade)

## Table of Contents
- [About the plugin](#about-the-plugin)
- [Installation](#installation)
- [Usage](#usage)
- [Support](#support)
- [Examples](#examples)
- [Contributing](#contributing)
- [History](#history)
- [Author](#author)
- [License](#license)

## About the plugin

jQuery Price Format Plugin is useful to format input fields and HTML elements as prices.
For example, if you type 123456, the plugin updates it to US$ 1,234.56.

Yes, we also have a prototype version but it is out of maintenace.

It is costumizable, so you can use other prefixes, separators, suffixes, plus sign, minus sign and so on. Check out the examples below.

## Installation

```sh
npm install --save https://github.com/flaviosilveira/Jquery-Price-Format.git
```

-or-

```sh
yarn add https://github.com/flaviosilveira/Jquery-Price-Format.git
```

## Usage

- [Install](#installation) or download the [jquery.priceformat.js](/jquery.priceformat.js) or [jquery.priceformat.min.js](/jquery.priceformat.min.js)
- Include then on your project `<script src="./your-project/jquery.priceformat.min.js"></script>`
- That's it, [see examples](#examples) and format your prices!
- Enjoy!

## Support

Please [open an issue](https://github.com/flaviosilveira/Jquery-Price-Format/issues/new) for support.

## Examples

**Example 1 - Basic Usage**

> This is the most basic usage. It loads default options: use US$ as prefix, a comma as thousands separator and a dot as cents separator.

```javascript
$('#example1').priceFormat();

// US$ 1,234.56
```

**Example 2 - Use with any HTML element**

> The same basic usage as above, but now using an HTML id. Try it with classes also.

```javascript
$('#htmlfield').priceFormat();
```

**Example 3 - Customize**

> This is a costumized format like brazilians use: R$ as prefix, a dot as cents separator and a dot as thousands separator. Play with the options centsSeparator and/or thousandsSeparator to better fit your site.

```javascript
$('#example2').priceFormat({
  prefix: 'R$ ',
  centsSeparator: ',',
  thousandsSeparator: '.'
});

// R$ 1.234,56
```

**Example 4 - Skipping some option**

> You can skip some of the options (prefix, centsSeparator and/or thousandsSeparator) by set them blank as you need it in your UI.

```javascript
$('#example3').priceFormat({
  prefix: '',
  thousandsSeparator: ''
});

// 1234.56
```

**Example 5 - Working with limits**

> You can set a limited length (limit) or change the size of the cents field (centsLimit) to better fit your needs.

```javascript
$('#example5').priceFormat({
  clearPrefix: true
});

// US$ 12.345
```

**Example 6 - Clear Prefix and Suffix on Blur**

> The default value of clearPrefix and clearSuffix is false. Both work in same way.

```javascript
$('#example5').priceFormat({
  clearPrefix: true
});

// 1,234.56
// on Blur > US$ 1,234.56
```

**Example 7 - Allow Negatives**

> The default value of allowNegative property is false. Zero values will not be negative.

```javascript
$('#example6').priceFormat({
  allowNegative: true
});

// US$ -1,234.56
```

**Example 8 - Add Suffix**

> The default value of suffix is empty.

```javascript
$('#example7').priceFormat({
  prefix: '',
  suffix: '€'
});

// 1,234.56€
```

**Exemplo 9 - Unmask function**

> Return the value without mask. Negative numbers will return the minus signal.

```javascript
$('#example8').priceFormat();
var unmask = $('#example8').unmask();
alert(unmask); // alert 123456
```

**Exemplo 10 - Plus sign**

> Sometimes show the plus sign can improve your usability. Since you allow this option you will automaticly allow the use of the minus sign.

```javascript
$('#example9').priceFormat({
  prefix: '',
  thousandsSeparator: '',
  insertPlusSign: 'true'
});

// +1234.56
```

## Contributing

Please contribute using [Github Flow](https://guides.github.com/introduction/flow/). Create a branch, add commits, and [open a pull request](https://github.com/flaviosilveira/Jquery-Price-Format/compare?expand=1).
Contributing

1. Fork it!
2. Create your feature branch: git checkout -b my-new-feature
3. Commit your changes: git commit -m 'Add some feature'
4. Push to the branch: git push origin my-new-feature
5. Submit a pull request :D

## History

See [Releases](https://github.com/flaviosilveira/Jquery-Price-Format/releases) for detailed changelog.

## Author

| [![github/cuducos](https://avatars6.githubusercontent.com/u/4732915?v=4&s=100)](https://github.com/cuducos/ "cuducos github profile") |
|---|
| [Eduardo Cuducos](https://github.com/cuducos/) |

## Maintainers

| [![github/flaviosilveira](https://avatars6.githubusercontent.com/u/373688?v=4&s=100)](https://github.com/flaviosilveira/ "flaviosilveira github profile") | [![github/nandomoreirame](https://avatars6.githubusercontent.com/u/1318271?v=4&s=100)](https://github.com/nandomoreirame/ "nandomoreirame github profile") |
|---	|---	|
| [Flávio da Silveira](https://github.com/flaviosilveira/) | [Fernando Moreira](https://github.com/nandomoreirame/) |

[Click here to see all contributors](https://github.com/flaviosilveira/Jquery-Price-Format/graphs/contributors).

## License

Code is under [MIT License](/LICENSE) - Copyright © jQuery-Price-Format
