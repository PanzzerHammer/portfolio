<!-- Banner -->

    <div id="bannerSmall" class="box container">
        <form action="index.php" method="GET" class="display">
            <input type="hidden" name="uc" value="<?= $uc ?>"/>
            <div class="row">
                <div class="4u 12u(medium)">
                    <p><input type="text" name="search" id="search" placeholder="<?= $placeholder ?>"/></p>
                </div>
                <div class="2u 12u(medium)">
                    <select name="genre">
                        <option value="-1">Genres</option>
                        
                        <?php
                        foreach ($lesGenres as $genre) {
                            ?>
                        <option value="<?= $genre['id_genre'] ?>" 
                            <?php if($genreFilter == $genre['id_genre']){ ?> selected="selected" <?php } ?> >
                            <?= $genre['nom_genre'] ?></option>
                        <?php } ?>
                        
                    </select>
                </div>
                <div class="2u 12u(medium)">
                    <select name="format">
                        <option value="-1">Formats</option>
                        
                        <?php
                        foreach ($lesFormats as $format) {
                            ?>
                        <option value="<?= $format['id_format'] ?>" 
                            <?php if($formatFilter == $format['id_format']){ ?> selected="selected" <?php } ?> >
                            <?= $format['nom_format'] ?></option>
                        <?php } ?>
                        
                    </select>
                </div>
                <div class="2u 12u(medium)">
                    <select name="support">
                        <option value="-1">Supports</option>
                        
                        <?php
                        $lesSupports = $pdo->getSupport();
                        foreach ($lesSupports as $support) {
                            ?>
                        <option value="<?= $support['id_support'] ?>" 
                            <?php if($supportFilter == $support['id_support']){?> selected="selected" <?php } ?> >
                            <?= $support['type_support'] ?></option>
                        <?php } ?>
                        
                    </select>
                </div>
                <div class="2u 12u(medium)">
                    <button type="submit" class="icon fa-search" value="Valider"/>
                </div>
            </div>
        </form>
    </div>