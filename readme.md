# Functions

* `get_aniomalia_breadcrumbs()` - builds array
* `aniomalia_breadcrumbs()` - outputs HTML


### Breadcrumb item data

* `title` — page name (blog name if no page is set for front page)
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
<nav class="aniomalia-breadcrumbs">
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

Use this plugin freely for personal or commercial projects. 

Plugin built by Raoul Simionas for Aniomalia.