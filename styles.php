<?php
// styles.php
function getGridStyles() {
    return "
        <style>
            .Grid {
                margin: 100px;
                margin-top: 100px;
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                row-gap: 150px;
                column-gap: 150px;
                justify-content: center;
                place-items: center;
            }
        </style>
    ";
}

function getContainerCardStyles() {
    return "
        <style>
            .ContainerCard {
                width: 300px;
                height: 500px;
                box-shadow: 10px 10px 15px 5px grey;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                border-radius: 15px;
            }
        </style>
    ";
}

function getContainerPriceQtyStyles() {
    return "
        <style>
            .ContainerPriceQty {
                display: flex;
                justify-content: space-around;
                width: 100%;
            }
        </style>
    ";
}

function getContainerTitleAndDescriptionStyles() {
    return "
        <style>
            .ContainerTitleAndDescription {
                margin-left: 10px;
                margin-right: 5px;
                text-align: center;
                height: 200px;
            }
        </style>
    ";
}

function getDivCartStyles($disabled) {
    $color = $disabled ? 'gray' : 'inherit';
    $hoverColor = $disabled ? 'gray' : 'red';
    $cursor = $disabled ? 'not-allowed' : 'pointer';

    return "
        <style>
            .DivCart {
                user-select: none;
                color: $color;
            }

            .DivCart:hover {
                color: $hoverColor;
                cursor: $cursor;
            }
        </style>
    ";
}
?>