# Breadcrumbs by Instinct

Simple to build custom HTML for breadcrumbs just as you want them without worrying about the functionality of the breadcrumbs themselves. Or if you prefer, use our simple formatted breadcrumbs. Simple is often better. More stuff coming to [Aniomalia](https://aniomalia.com/).

### Functions

* `get_aniomalia_breadcrumbs()` - outputs array
* `aniomalia_breadcrumbs()` - outputs HTML


### Breadcrumb item data

* `title` - page name (site name if no page is set for frontpage option)
* `url` - full permalink to page
* `type` - useful for customizing by type
	* `home`
	* `parent`
	* `blog`
	* `category`
	* `tag`
	* `taxonomy`
	* `author`
	* `current`


### Example: Custom HTML

```PHP
<?php $breadcrumbs = get_aniomalia_breadcrumbs(); ?>

<?php if ( ! is_front_page() ) : ?>
<nav class="breadcrumbs">
	<ul>
		<?php foreach ( $breadcrumbs as $item ) : ?>
		<li> 
			<a href="<?php echo $item['url']; ?>">
				<?php if ( $item['type'] == 'home' ) : ?>
					<i class="icon-home"></i>
				<?php else : ?>
					<?php echo $item['title']; ?>
				<?php endif; ?>
			</a>
		</li>
		<?php endforeach; ?>
	</ul>
</nav>
<?php endif; ?>
```


### License

This plugin is released under a GPL license. Read more [here](http://www.gnu.org/licenses/gpl-2.0.html])