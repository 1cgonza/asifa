<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
  <label>
    <input type="search" class="search-field" placeholder="..." value="<?php echo get_search_query(); ?>" name="s" title="Buscar" />
  </label>
  <button type="submit" class="search-submit"><span class="search-icon"></span></button>
</form>