<?php
echo
"<p>[Filter]</p><hr>

    <input id='artist' type='search' placeholder='Artist name' data-search>
    <br><br>
    Category:
    <hr>
    <ul id='item-category'>
        <li id='abandoned' onclick='filterCategory(\"abandoned\")'>Abandoned</li>
        <li id='bombing' onclick='filterCategory(\"bombing\")'>Bombing</li>
        <li id='city' onclick='filterCategory(\"city\")'>City</li>
        <li id='freight' onclick='filterCategory(\"freight\")'>Freight</li>
        <li id='handstyle' onclick='filterCategory(\"handstyle\")'>Handstyle</li>
        <li id='throwup' onclick='filterCategory(\"throwup\")'>Throwup</li>
        <li id='train' onclick='filterCategory(\"train\")'>Train</li>
        <li id='legal' onclick='filterCategory(\"legal\")'>Legal</li>
        <li id='all' onclick='filterCategory(\"all\")'>All</li>
    </ul>
    <br>
    <div style='display: flex; justify-content:end;'>
    <button onclick='clearInputs()' style='padding: 3px;'>Reset</button></div>";
