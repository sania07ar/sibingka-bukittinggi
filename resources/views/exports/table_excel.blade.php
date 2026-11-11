<table>
    <tr>
        <td colspan="{{ $maxCols }}" style="font-size: 11pt; font-weight: bold; text-align: left;">
            {{ $titleId }}
        </td>
    </tr>
    @if(!empty($titleEn))
    <tr>
        <td colspan="{{ $maxCols }}" style="font-size: 9.5pt; font-style: italic; color: #475569; text-align: left;">
            {{ $titleEn }}
        </td>
    </tr>
    @endif
    <tr>
        <td colspan="{{ $maxCols }}"></td>
    </tr>
    {!! $cleanTableHtml !!}
    <tr>
        <td colspan="{{ $maxCols }}"></td>
    </tr>
    <tr>
        <td colspan="{{ $maxCols }}" style="font-size: 9pt;">
            Sumber / Source: {{ $source ?? 'BPS Kota Bukittinggi' }}
        </td>
    </tr>
    @if(!empty($note))
    <tr>
        <td colspan="{{ $maxCols }}" style="font-size: 8pt; color: #555555;">
            Catatan / Note: {{ $note }}
        </td>
    </tr>
    @endif
</table>
