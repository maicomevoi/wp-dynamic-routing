# WP Dynamic Routing Plugin

WP Dynamic Routing Plugin allows you to easily define and handle custom routes in your WordPress site. It supports static and dynamic routes, closures, and the ability to use parameters directly via `$_GET` and `$_POST`.

## Installation

1. Download the plugin files and place them in the `wp-content/plugins/wp-dynamic-routing` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

## Usage

Once activated, the plugin is ready to use. You can define routes using the `add_route` function. Here are examples for static routes, dynamic routes, and closures.

### Adding Routes

You can add routes using the `add_route` function. Routes will always have a leading slash (`/`) regardless of whether the user includes it or not.
