
Moja grupa:</p>
</br><p><a href='nagroda.php?a=dodaj_osoby_do_nagrody&id=3' class='btn btn-info'>Dodaj osoby do nagrody</a>
</p>
<table class='table'>
    <tr><th>Imie i nazwisko</th><th>Grupa nagrody</th><th>Przypisanie</th></tr>
    <tr><td>Tomasz Rzemieniecki </td><td>Podpadziochy - 965.52 zł</td>
        <td>
            <form method='post' action='nagroda.php?a=aktualizuj_nagrode&id=21'>
                <select name='grupa'>
                    <option value='2'>Wyróżnienie</option>
                    <option value='3'>Standardowa</option>
                    <option value='4'>Podpadziochy</option>
                    <option value='5'>Brak</option>
                </select>
                <input type='submit' class='btn-sm btn-warning' value='Aktualizuj'>
            </form></td>
    </tr>
</table>
