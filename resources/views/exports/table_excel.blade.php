<table>
    <thead>
        <tr>
            <th colspan="{{ $maxCols }}" style="font-size: 13pt; font-weight: bold; text-align: left; height: 26px;">
                Tabel {{ $tableCode }} {{ $titleId }}
            </th>
        </tr>
        <tr>
            <th colspan="{{ $maxCols }}" style="font-size: 10pt; font-style: italic; color: #555555; text-align: left; height: 22px;">
                Table {{ $titleEn }}
            </th>
        </tr>
        <tr>
            <th colspan="{{ $maxCols }}" style="height: 12px;"></th>
        </tr>
    </thead>
</table>

<table>
    {!! $cleanTableHtml !!}
</table>

<table>
    <tfoot>
        <tr>
            <td colspan="{{ $maxCols }}" style="height: 12px;"></td>
        </tr>
        <tr>
            <td colspan="{{ $maxCols }}" style="font-size: 9pt; height: 20px;">
                <strong>Sumber / <em>Source:</em></strong> {{ $source ?? 'BPS Kota Bukittinggi' }}
            </td>
        </tr>
        @if(!empty($note))
        <tr>
            <td colspan="{{ $maxCols }}" style="font-size: 8pt; color: #555555; height: 18px;">
                <strong>Catatan / <em>Note:</em></strong> {{ $note }}
            </td>
        </tr>
        @endif
    </tfoot>
</table>

