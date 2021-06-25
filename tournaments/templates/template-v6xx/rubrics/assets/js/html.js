// Modular HTML buttons 3.4.0 Dynamic Content Replacer

all_mission = []

window.mobileAndTabletCheck = function () {
    let check = false;
    (function (a) {
        if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino|android|ipad|playbook|silk/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) check = true;
    })(navigator.userAgent || navigator.vendor || window.opera);
    return check;
};

buffer = ""

function clearbuffer() {
    buffer = ""
}

function writebuffer(element) {
    document.getElementById(element).innerHTML = buffer
}

function addToBuffer(data) {
    buffer = buffer + data
}

function createbutton(mission, points, description) {
    window[mission] = 0
    window[mission + 'save'] = 0
    window["yesText" + description] = 0
    window["noText" + description] = 0
    addToBuffer('<tr>\
<td style="font-size: 90%; padding-left: 10px; padding-right: 5px; background-color: sky;" id="'+ description + '"><!--<i class="only-print">__/' + points.toString() + '</i>-->\
  '+ description + '\
  </td>\
  </tr>\
  <tr>\
  <td>\
  <fieldset data-role="controlgroup" data-theme="b" data-type="horizontal" style="text-align: center;">\
  <label for="yes'+ mission + '" style="font-size: 12px;" id="yesText' + description + '">Yes</label>\
  <input  type="radio" onclick="check_missions(\''+ mission + '\');recalc(' + points + ',\'' + mission + '\',1)" name="' + mission + '" value="true" id="yes' + mission + '" checked=false>\
  <label for="no'+ mission + '" style="font-size: 12px;" id="noText' + description + '">No</label>\
  <input  type="radio" onclick="check_missions(\''+ mission + '\');recalc(0,\'' + mission + '\', 0)" name="' + mission + '"  value="false" id="no' + mission + '" checked="true">\
  </fieldset>\
  </td>\
  </tr>')
}

function create3button(mission, points, points2, description) {
    window[mission] = 0
    window[mission + 'save'] = 0
    window["completelyText" + description] = 0
    window["partiallyText" + description] = 0
    window["noText" + description] = 0
    addToBuffer('<tr>\
  <td style="font-size: 90%; padding-left: 10px; padding-right: 5px; background-color: sky;" id="'+ description + '">\
  '+ description + '\
  </td>\
  </tr>\
  <tr>\
  <td>\
  <fieldset data-role="controlgroup" data-theme="b" data-type="horizontal" style="text-align: center; font-size: 50%;">\
  <label for="completely'+ mission + '" style="font-size: 12px;" id="completelyText' + description + '">Completely</label>\
  <input  type="radio" onclick="check_missions(\''+ mission + '\');recalc(' + points2 + ',\'' + mission + '\',2)" name="' + mission + '" value="completely" id="completely' + mission + '" checked=false>\
  <label for="partly'+ mission + '" style="font-size: 12px;" id="partlyText' + description + '">Partly</label>\
  <input  type="radio" onclick="check_missions(\''+ mission + '\');recalc(' + points + ',\'' + mission + '\',1)" name="' + mission + '" value="partly" id="partly' + mission + '" checked=false>\
  <label for="no'+ mission + '" style="font-size: 12px;" id="noText' + description + '">No</label>\
  <input  type="radio" onclick="check_missions(\''+ mission + '\');recalc(0,\'' + mission + '\', 0)" name="' + mission + '"  value="false" id="no' + mission + '" checked="true">\
  </fieldset>\
  </td>\
  </tr>')
}

function createcomment(description) {
    addToBuffer('<tr>\
  <td style="text-shadow: none;font-size: 90%; padding-left: 10px; padding-right: 5px; color: #990000" id="'+ description + '">\
  '+ description + '\
  </td>\
  </tr>')
}

function createrange(mission, increment, min, max, start, description) {
    window[mission] = 0
    window[mission + 'save'] = 0
    window[mission + 'inc'] = increment

    addToBuffer('<tr>\
  <td style="font-size: 90%; padding-left: 10px; padding-right: 5px;" id="'+ description + '">\
  '+ description + '	  </td>\
  </tr>\
  <tr>\
  <td >\
  <input type="range" increment="'+ increment + '" data-highlight="true" data-theme="b" data-show-value="true" name="' + mission + '" id="' + mission + '" value="' + start + '" min="' + min + '" max="' + max + '" step="1" onchange="check_missions(\'' + mission + '\');recalc(this.value*' + increment + ',\'' + mission + '\',this.value);">\
  <p id="'+ mission + 'Txt" style="color: red"></p>\
  </td>\
  </tr>')
    // if (start > 0) {
    // $(document).ready(function() {
    //     recalc(increment*start,mission,start)
    // });
    // }
}


function createdropdown(mission, items, points, description) {
    window[mission] = 0
    window[mission + 'save'] = 0

    addToBuffer('<tr>\
  <td style="font-size: 90%; padding-left: 10px; padding-right: 5px;" id="'+ description + '">\
  '+ description + '	  </td>\
  </tr>\
  <tr>\
  <td >\
      <select onclick="check_missions(\''+ mission + '\');recalc(parseInt(this.value),\'' + mission + '\',$(\'select#select' + mission + '\')[0].selectedIndex)" name="' + mission + '" id="select' + mission + '" id="select-native-1"> ')
    addToBuffer('<option value="0" id="' + description + '0"></option>')
    i = 0
    while (i < items.length) {
        addToBuffer('<option  value="' + points[i] + '" id="' + items[i] + '">' + items[i] + '</option>')
        i = i + 1
    }
    addToBuffer('</select>\
  <p id="'+ mission + 'Txt" style="color: red"></p>\
  </td>\
  </tr>')
}


function starttable(mission, title, image, children, extrarows) {
    x = 0

    if (mission == "A00") {
        missionDisp = ""
    }
    else {
        window["mNum" + title] = 0
        missionDisp = "<text id='mNum" + title + "'>missionNumbering</text>" + mission.split("M")[1] + " - "
    }
    //width="'+(window.innerWidth/columnCount-5)+'"
    element = 1 + 2 * children.length + extrarows
    all_mission = all_mission.concat([[mission, children]])
    addToBuffer('\
  <div class="missionFmt">\
  <table style="width:100%; border: 1px solid black; border-collapse: collapse; " border="1">\
  <tr>\
    <td rowspan="'+ element + '" width="60px"> <img src="assets/missions/' + image + '" width="58px"></td>\
    <td style="font-size: 110%; text-align: center; background-color: green; color: white;">\
  '+ missionDisp + ' <text id="' + title + '">' + title + '</text>: ' + '\
      <i style="font-style: normal;" id="'+ mission + 'pts">0</i>\
    </td>\
  </tr>\
  ')
}

function endtable() {
    addToBuffer('</tr></td></table></div>')
}

function startrow(width) {
    if (window.innerWidth > width) {
        //alert(screen.width)
        //alert(width)
        addToBuffer('<td width="' + (100 / columnCount) + '%" style="padding-right: 2px; padding-left: 2px;" valign="top">')
    }
}
function endrow(width) {
    if (window.innerWidth < width) {
        //alert('activate')
        addToBuffer('</td>')
    }
}

//Legacy column manager
function breakrow(minwidth, maxwidth) {
    if (window.innerWidth > minwidth && window.innerWidth < maxwidth) {
        addToBuffer('</td>')
        addToBuffer('<td width="' + (100 / columnCount) + '%" style="padding-right: 2px;" valign="top">')
    } else {
    }
}

//addToBuffer('hi')

function startRubric() {
    addToBuffer(' <table cellspacing="0">')
}

function endRubric() {
    addToBuffer(' </table>')
}

function startRow() {
    addToBuffer("<tr>")
}

function addSectionTitle(title) {
    addToBuffer('<td class="rbtd" > \
    <p class="s2" style="">'+ title + '</p>\
    </td>')
}

rbchildren = []
ssecct = 0
function addSubSection(description, color, children) {
    addToBuffer('<td class="rbtd" style="height:40px;border:1px solid black;color: black !important;" colspan="4" bgcolor="' + color + '">\
      <div style="display: flex;"><div style="margin-left:5px;flex: 0 0 95%;">  '+ description + '   </div> <div style="text-align:right;color:red;flex:1;margin-right:5px;">  <b style="text-align:right; color:red" id="' + ssecct + description.split(" ")[0] + '"></b>  </div>    \
    </td>')
    rbchildren.push([ssecct + description.split(" ")[0], children])
    ssecct = ssecct + 1
}

function closeRow() {
    addToBuffer("</tr>")
}

function addOption(name, value, id) {
    addToBuffer('<td class="rbtd" style="border:1px solid black;">\
      <label for="'+ name + id + '" class="ui-btn ui-corner-all ui-btn-inherit ui-btn-icon-left ui-radio-off"><span class="ui-btn-text">' + value + '</span> </label>\
              <input data-corners="true" data-shadow="true" data-iconshadow="true" data-wrapperels="span" data-icon="null" data-iconpos="null" data-theme="c" onclick="rubricCalc()" value="'+ id + '" class="rbitem" type="radio" name="' + name + '" id="' + name + id + '">\
    </td>')
}

function addCVOption(name, value, id) {
    addToBuffer('<td class="rbtd" style="text-align:center;align-items:center;border:1px solid black;">\
      \
            <label> <input onclick="rubricCalc()" value="'+ id + '" class="rbitem" type="radio" name="' + name + '" id="' + name + id + '"></label>\
    </td>')
}

function addFreeOption(name, id) {
    if (!mobileAndTabletCheck()) {
        addToBuffer('<td class="rbtd" style="border:1px solid black;">\
        <label for="'+ name + id + '" class="ui-btn ui-corner-all ui-btn-inherit ui-btn-icon-left ui-radio-off">      <textarea class="rbitem" id="text' + name + '" cols="50" height="100%"></textarea>\
        </label>\
        \
        \
                <input onclick="rubricCalc()" value="'+ id + '" class="rbitem" type="radio" name="' + name + '" id="' + name + id + '">\
        </td>')
    } else {
        addToBuffer('<td class="rbtd" style="border:1px solid black;">\
        <label for="'+ name + id + '" class="ui-btn ui-corner-all ui-btn-inherit ui-btn-icon-left ui-radio-off">    \
        </label>\
        \
        \
                <input onclick="rubricCalc()" value="'+ id + '" class="rbitem" type="radio" name="' + name + '" id="' + name + id + '">  <textarea class="rbitem" id="text' + name + '" cols="50" height="100%"></textarea>\
        </td>')
    }
}


function addCVFree(name, id) {
    addToBuffer('<td class="rbtd" rowspan="2" style="border:1px solid black;">\
    <textarea class="rbitem" id="text'+ name + '" cols="50" height="100%"></textarea>\
    </td>')
}

function addComments(name) {
    addToBuffer('<tr><td  style="text-align:center;" colspan="4"><b><br>Feedback Comments</b></td></tr><tr><td style="text-align:center;" colspan="2">Great Job:</td><td style="text-align:center;" colspan="2">Think about:</td></tr><tr><td  colspan=2>\
      <textarea class="rbitem" id="text'+ name + '1" width="100%" height="100%"></textarea>\
    </td><td  colspan=2>\
    <textarea class="rbitem" id="text'+ name + '2" width="100%" height="100%"></textarea>\
  </td></tr>')
}

function addLevels(color1, color2, color3, color4) {
    addToBuffer('<td bgcolor="' + color1 + '" class="rbtd" style="color:black !important;text-align: center;font-weight: bold;">Beginning<br>1</td><td bgcolor="' + color2 + '" style="color:black !important;text-align: center;font-weight: bold;" class="rbtd">Developing<br>2</td><td bgcolor="' + color3 + '" class="rbtd" style="color:black !important;text-align: center;font-weight: bold;">Accomplished<br>3</td><td style="color:black !important;text-align: center;font-weight: bold;" bgcolor="' + color4 + '" class="rbtd">Exceeds<br>4<br><i>How has the team exceeded?</i></td>')
}



function addCVLevels(color1, color2, color3, color4) {
    addToBuffer('<td bgcolor="' + color1 + '" class="rbtd" style="color:black !important;text-align: center;width:20%;"><b>Beginning</b><br>Minimal examples observed across the team<br>1</td><td bgcolor="' + color2 + '" style="color:black !important;text-align: center;width:20%;" class="rbtd"><b>Developing</b><br>Some examples observed across the team<br>2</td><td bgcolor="' + color3 + '" class="rbtd" style="color:black !important;text-align: center;width:20%;"><b>Accomplished</b><br>Multiple examples observed across the team<br>3</td><td style="color:black !important;text-align: center;width:20%;" bgcolor="' + color4 + '" class="rbtd"><b>Exceeds</b><br>4</td><td bgcolor="black" style="text-align:center;color:white!important">Explain how team exceeds</td>')
}

function addStrengths(item1, item2, item3, item4) {
    addToBuffer('    <fieldset data-role="controlgroup">    <td colspan="5">\
<input class="rbitem" type="checkbox" id="'+ item1.split(" ")[0] + '" name="' + item1.split(" ")[0] + '">\
<label for="'+ item1.split(" ")[0] + '">' + item1 + '</label>\
    <label for="'+ item2.split(" ")[0] + '">\
    '+ item2 + '\
            <input class="rbitem" type="checkbox" id="'+ item2.split(" ")[0] + '" name="' + item2.split(" ")[0] + '">    </label>\
    \
    <label for="'+ item3.split(" ")[0] + '">' + item3 + '\
            <input class="rbitem" type="checkbox" id="'+ item3.split(" ")[0] + '" name="' + item3.split(" ")[0] + '">    </label>\
    \
    \
    </fieldset>    ')
}