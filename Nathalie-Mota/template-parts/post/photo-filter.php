<?php
      
?>

<div class="filter-area">
    <form>
        <div class="filterleft">
            <div id="filtre-categorie" class="select-filter">
                <span class="categorie_id-down select-close"></span>
                <select class="option-filter" name="categorie_id" id="categorie_id">
                    <option value="">Catégories</option>
                    <?php
                    // Récupération des catégories
                    $categories = get_terms('categorie-acf');
                    // Récupération de la catégorie actuellement sélectionnée
                    $selected_category = isset($_GET['categorie_id']) ? $_GET['categorie_id'] : '';
                    foreach ($categories as $category) {
                        echo '<option value="'. $category->term_taxonomy_id .'"'.
                             ($selected_category == $category->term_taxonomy_id ? ' selected' : '').
                             '>'. $category->name .'</option>';
                    }
                    ?>
                </select>
            </div>

            <div id="filtre-format" class="select-filter">
                <span class="format_id-down select-close"></span>
                <select class="option-filter" name="format_id" id="format_id">
                    <option value="">Formats</option>
                    <?php
                    // Récupération des formats
                    $formats = get_terms('format-acf');
                    // Récupération du format actuellement sélectionné
                    $selected_format = isset($_GET['format_id']) ? $_GET['format_id'] : '';
                    foreach ($formats as $format) {
                        echo '<option value="'. $format->term_taxonomy_id .'"'.
                             ($selected_format == $format->term_taxonomy_id ? ' selected' : '').
                             '>'. $format->name .'</option>';
                    }
                    ?>
                </select>
            </div>
        </div>
        
        <div class="filterright">
            <div id="filtre-date" class="select-filter">
                <span class="date-down select-close"></span>
                <select class="option-filter" name="date" id="date">
                    <option value="">Trier par</option>
                    <option value="desc" <?php echo isset($_GET['date']) && $_GET['date'] == 'desc' ? 'selected' : ''; ?>>Nouveautés</option>
                    <option value="asc" <?php echo isset($_GET['date']) && $_GET['date'] == 'asc' ? 'selected' : ''; ?>>Les plus anciens</option>
                </select>
            </div>
        </div>
    </form>
</div>