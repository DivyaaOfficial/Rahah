<style>
    input[type="button"] {
        padding: 8px 12px;
        font-size: 14px;
        background-color: #FC6C85;
        color: #fff;
        border: none;
        border-radius: 3px;
        cursor: pointer;
        margin-right: 5px;
    }

    input[type="button"]:hover {
        background-color: #F25278;
    }

    button {
        padding: 8px 12px;
        font-size: 14px;
        background-color: #FC6C85;
        color: #fff;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }

    button:hover {
        background-color: #F25278;
    }
</style>

<script>
function ubahsaiz(gandaan) {
    var saiz = document.getElementById("saiz");
    var saiz_semasa = saiz.style.fontSize || "1";

    if (gandaan == 2)
    {
        saiz.style.fontSize = "1em";
    }
    else
    {
        saiz.style.fontSize = (parseFloat(saiz_semasa) + (gandaan * 0.2)) + "em";
    }        
}    
</script>

| ubah saiz tulisan |
<input name="reSize1" type="button" value="reset" onclick="ubahsaiz(2)" />
<input name="reSize" type="button" value="&nbsp;+&nbsp;" onclick="ubahsaiz(1)" />
<input name="reSize2" type="button" value="&nbsp;-&nbsp;" onclick="ubahsaiz(-1)" />
|
<button onclick="window.print()">Cetak</button>