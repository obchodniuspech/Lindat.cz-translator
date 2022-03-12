# Lindat.cz translator
 
git clone https://github.com/obchodniuspech/Lindat.cz-translator.git && cd Lindat.cz-translator && composer install
cd ../ && sudo chmod -R 775 ./Lindat.cz-translator && sudo chmod -R 777 ./Lindat.cz-translator/storage

nasledne přejmenujte example env soubor a nastavte spravne pripojeni k db

cd Lindat.cz-translator && php artisan migrate:fresh
