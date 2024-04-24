// 현재 URL의 쿼리 매개변수 가져오기
var queryString = window.location.search;

// URLSearchParams 객체 생성
var urlParams = new URLSearchParams(queryString);

// 쿼리값 가져오기
var query_value = urlParams.get("co");

if (query_value) {
    document.getElementById('company_list').value = query_value;
}

// -- functions -- //
function submitForm() {
    var selectedOption = document.getElementById('company_list').value;
    var url = window.location.href.split('?')[0]; // 현재 페이지 URL을 가져옵니다.
    url += '?co=' + encodeURIComponent(selectedOption); // URL에 쿼리 값을 추가합니다.

    // 새로운 URL로 리디렉션합니다.
    window.location.href = url;
}

function connectRedmine(path) {
    var protocol = window.location.protocol;
    var hostname = window.location.hostname;
    // var path = "/projects";
    var redmine = protocol + "//" + hostname + ":3000" + path;
    // if (path2) {
    //     redmine += path2;
    // }
    console.log(protocol);
    console.log(hostname);
    console.log(redmine);
    window.open(redmine, '_blank');
}

// 현재 페이지의 이전 URL 가져오기
function getPreviousPageUrl() {
    return document.referrer;
}

// 페이지 이동 함수
function redirectToPreviousPage() {
    var previousUrl = getPreviousPageUrl();
    var pidValue = document.getElementById('pid').textContent;
    var reprotocol = window.location.protocol;
    var rehostname = window.location.hostname;
    
    console.log("이전페이지: ", previousUrl);
    console.log("pidValue: ", pidValue);

    if (!previousUrl)
    {
        window.location = '/list/servers/?co=' + pidValue;
    }
    else
    {
        window.location.href = previousUrl;
    }
}

function createForm() {
    console.log('init createForm()');
    var buttonRow = document.getElementById("createR");
    var inputRow = document.getElementById("cForm");
    var inputRowCol = document.getElementById("cFormBar");
    buttonRow.classList.add("hidden");
    inputRow.classList.remove("hidden");
    if(inputRowCol)
    {
        inputRowCol.classList.remove("hidden");
    }

    var listSelectedinTR = document.querySelectorAll("#cForm td");
    var selectedTD = listSelectedinTR[1];
    var childofSelectedTD = selectedTD.querySelector(':first-child');
    childofSelectedTD.focus();
}

function createdata() {
    console.log("initiating function createdata");

    var inputs = document.querySelectorAll("#cForm input");
    var select = "";
    var formData = new FormData();
    
    if(document.getElementById("company_options"))
    {
        select = document.getElementById("company_options").value;
        if(select != '0')
        {
            formData.append('pid', select);
        }
    }
    
    inputs.forEach(function(input) {
        formData.append(input.name, input.value);
    });

    return new Promise(function(resolve, reject) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'create.php', true);
        // xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == XMLHttpRequest.DONE) {
                if (xhr.status >= 200 && xhr.status < 300) {
                    console.log('sending data: ' + xhr.responseText); // debugging
                    var response = JSON.parse(xhr.responseText);
                    if (response.error) {
                        reject(response.error);
                    } else {
                        resolve(response);
                    }
                } else {
                    reject(xhr.statusText);
                    console.error('Error occurred: ' + xhr.status);
                }
            }
        };
        xhr.onerror = function() {
            reject(xhr.statusText); // Network error
        };
        xhr.send(formData);
    });
}

function refreshContent() {
    var queryString = window.location.search;
    var urlParams = new URLSearchParams(queryString);
    var co = urlParams.get('co');
    var coQuery = "?co=" + co;
    var php = "index.php";
    if (co) {
        php += coQuery;
    }
    
    return new Promise(function(resolve, reject) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4) {
                if (this.status == 200) {
                    var responsetext = this.responseText;
                    var tempDiv = document.createElement("div");
                    tempDiv.innerHTML = responsetext;
                    var content = tempDiv.querySelector("#servertable").innerHTML;
                    document.getElementById("servertable").innerHTML = '';
                    document.getElementById("servertable").innerHTML = content;
                    console.log("CONTENT: ")
                    console.log(content);
                    resolve(content);
                } else {
                    reject(new Error('요청실패'));
                }
            }
        };
        xhttp.open("POST", php, true);
        xhttp.send();
    });
}

function updatedata(id, columnt, column, newText) {
    console.log("Update data for ID: " + id + ", 위치: " + columnt + ", Column:" + column + ", Text: " + newText);


    return new Promise(function(resolve, reject) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'update.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == XMLHttpRequest.DONE) {
                if (xhr.status == 200) {
                    console.log('sending data: ' + xhr.responseText); // debugging
                    var response = JSON.parse(xhr.responseText);
                    if (response.error) {
                        reject(response.error);
                    } else {
                        resolve(response);
                    }
                } else {
                    console.error('Error occurred: ' + xhr.status);
                    reject(xhr.status);
                }
            }
        };
        var params = 'id=' + encodeURIComponent(id) + '&column=' + encodeURIComponent(column) + '&newText=' + encodeURIComponent(newText);
        xhr.send(params);
    });

    // var xhr = new XMLHttpRequest();
    // xhr.open('POST', 'update.php', true);
    // xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    // xhr.onreadystatechange = function() {
    //     if (xhr.readyState == XMLHttpRequest.DONE) {
    //         if (xhr.status == 200) {
    //             console.log('sending data: ' + xhr.responseText); // debugging
    //         } else {
    //             console.error('Error occurred: ' + xhr.status);
    //         }
    //     }
    // };
    // var params = 'id=' + encodeURIComponent(id) + '&column=' + encodeURIComponent(column) + '&newText=' + encodeURIComponent(newText);
    // xhr.send(params);
}

function updatedata4detail(data, data2) {
    console.log("data: ", data);
    console.log("initiating function createdata");

    var id = data2.querySelector('.detail_id');
    var sid = document.querySelector('.detail_sid');
    var formData = new FormData();
    
    formData.append(id.id, id.textContent);
    formData.append(sid.id, sid.textContent);

    for (var i = 0; i < data.length; i++)
    {
        var date = data[i];
        formData.append(date.parentElement.id, date.value);
    }

    return new Promise(function(resolve, reject) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'update.php', true);
        // xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == XMLHttpRequest.DONE) {
                if (xhr.status >= 200 && xhr.status < 300) {
                    resolve(xhr.responseText);
                    console.log('sending data: ' + xhr.responseText); // debugging
                } else {
                    reject(xhr.statusText);
                    console.error('Error occurred: ' + xhr.status);
                }
            }
        };
        xhr.onerror = function() {
            reject(xhr.statusText); // Network error
        };
        xhr.send(formData);
    });
}

function deletedata(data) {
    return new Promise(function(resolve, reject) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'delete.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == XMLHttpRequest.DONE) {
                if (xhr.status == 200) {
                    console.log('sending data: ' + xhr.responseText); // debugging
                    resolve(data);
                } else {
                    console.error('Error occurred: ' + xhr.status);
                }
            }
        };
        xhr.onerror = function() {
            reject(xhr.statusText); // Network error
        };
        xhr.send(data);
    });
}

function editEvent(a) {
    console.log('initating func editEvent()');
    console.log(a);
    
    var originalContent = '';
    var isEditing = false;
    // var dblclickcheck = false;
    var entercheck = false;
    var entercheck2 = false;
    var esccheck = false;
    var esccheck2 = false;

    var editableCells = document.querySelectorAll('.editable');
    if(editableCells){
        editableCells.forEach(function(cell) {
            cell.addEventListener('dblclick', function() {
                if(!isEditing)
                {
                    isEditing = true;
            
                    if(cell.id === "periodstart" || cell.id ==="periodend" || cell.id === "updatedate")
                    {
                        // 현재 텍스트 값 가져오기
                        const currentDate = this.textContent;
                        
                        // <input type="date"> 요소 생성
                        const inputDate = document.createElement("input");
                        inputDate.type = "date";
                        inputDate.value = currentDate;

                        // 기존 텍스트를 숨기고 input을 보여줌
                        this.textContent = "";
                        this.appendChild(inputDate);

                        inputDate.focus();

                        // input에서 포커스를 잃을 때 (blur 이벤트) 변경된 날짜 저장
                        inputDate.addEventListener("blur", function() {
                            // if (currentDate !== inputDate.value && !entercheck2 && !esccheck2) {    
                                cell.textContent = currentDate;

                                isEditing = false;

                                // 이벤트 리스너 삭제
                                this.remove();
                            // }
                        });
                        
                        inputDate.addEventListener('keypress', function(e) {    
                            var newdata = inputDate.value.trim();
                            var cell = inputDate.parentElement;
                            var id = cell.parentElement.id; // assuming you have unique IDs for rows
                            var columnt = Array.prototype.indexOf.call(cell.parentElement.children, cell); // assuming you want to update the same column
                            var column = cell.id;
                            
                            entercheck2 = true;
                            if (e.key === 'Enter')
                            {
                                console.log('check cal value: ');
                                console.log(this.value);
                                if(this.value == "0001-01-01")
                                {
                                    cell.textContent = "";
                                    newdata = "";
                                }
                                else
                                {
                                    cell.textContent = this.value;
                                }

                                isEditing = false;

                                updatedata(id, columnt, column, newdata)
                                    .then(function(response) {
                                        // 이벤트 리스너 삭제
                                        console.log("response: ");
                                        console.log(response);
                                        this.remove();
                                    })
                                    .catch(function(error) {
                                        console.error("inputDate Event err: ", error);
                                        alert('update에 실패했습니다.');
                                    });
                            }
                            entercheck2 = false;
                        });

                        inputDate.addEventListener('keydown', function(e) {
                            esccheck2 = true;
                            if(e.key === 'Escape') {
                                cell.textContent = currentDate;

                                isEditing = false;

                                // 이벤트 리스너 삭제
                                this.remove();
                            }
                            esccheck2 = false;
                        });
                    }
                    else
                    {
                        originalContent = this.textContent.trim();
                        var textarea = document.createElement('textarea');
                        textarea.classList.add('edit_area');
                        textarea.value = originalContent;
                        this.innerHTML = '';
                        this.appendChild(textarea);
                        textarea.focus();

                        textarea.addEventListener('blur', function() {
                            if (originalContent !== textarea.value && !entercheck && !esccheck)
                            {
                                var confirmResult = confirm("변경을 취소하시겠습니까?");
                                if (confirmResult)
                                {
                                    isEditing = false;
                                    cell.textContent = originalContent;
                                }
                                else
                                {
                                    setTimeout(() => {
                                        textarea.focus();    
                                    }, 0);
                                }
                            }
                            else
                            {
                                entercheck = false;
                                isEditing = false;
                                cell.textContent = originalContent;
                            }
                        });

                        textarea.addEventListener('keypress', function(e) {
                            if (e.key === 'Enter') {
                                entercheck = true;
                                if (textarea) {
                                    var newText = textarea.value.trim();
                                    var cell = textarea.parentElement;
                                    var id = cell.parentElement.id; // assuming you have unique IDs for rows
                                    var columnt = Array.prototype.indexOf.call(cell.parentElement.children, cell); // assuming you want to update the same column
                                    var column = cell.id;
                                    updatedata(id, columnt, column, newText)
                                    .then(function(response) {
                                        // 이벤트 리스너 삭제
                                        console.log("response: ");
                                        console.log(response);
                                        cell.textContent = newText;
                                        isEditing = false;
                                        // originalContent = '';
                                        entercheck = false;
                                    })
                                    .catch(function(error) {
                                        console.error("inputDate Event err: ", error);
                                        var catchString = "'sn'";
                                        console.log(catchString);
                                        if(typeof error == "string")
                                        {
                                            if(error.includes(catchString))
                                            {
                                                alert('update에 실패했습니다. 기존에 등록된 S/N가 있습니다.');
                                            }
                                            else
                                            {
                                                alert('update에 실패했습니다.');
                                            }
                                        }
                                        alert('update에 실패했습니다.');
                                    });
                                }
                            }
                        });
                        
                        textarea.addEventListener('keydown', function(e) {
                            esccheck = true;
                            if (e.key === 'Escape') {
                                if (textarea) {
                                    isEditing = false; 
                                    var cell = textarea.parentElement;
                                    cell.textContent = originalContent;
                                }
                            }
                            entercheck = false;
                            esccheck = false;
                        });
                    }
                }
            });
        });
    }
}

function editEvent4detail(a) {
    console.log('initating func editEvent4detail()');
    console.log(a);

    var originalContent = {};


    // if(document.querySelector('.detail_value'))
    // {
        var allBtns = document.querySelectorAll('.btnintable');
        allBtns.forEach(function(btn) {
            var buttonType11 = btn.querySelector("#createUpdateForm");
            var buttonType12 = btn.querySelector("#back2list");
            var buttonType21 = btn.querySelector("#updateDetail");
            var buttonType22 = btn.querySelector("#cancle2update");
        
            buttonType11.addEventListener('click', function(e) {                    
                var table = e.target.closest('table');
                var editableCells = table.querySelectorAll('.detail_value');

                buttonType11.classList.add("hidden");
                buttonType12.classList.add("hidden");
                buttonType21.classList.remove("hidden");
                buttonType22.classList.remove("hidden");

                editableCells.forEach(function(cell) {

                    originalContent[cell.id] = cell.textContent.trim();
                    cell.innerHTML = '';
                    var newEl;
                    if (cell.id==="note" || cell.id==="diskmodel" )
                    {
                        newEl = document.createElement('textarea');
                        newEl.value = originalContent[cell.id];
                    }
                    else if(cell.id === "tool")
                    {
                        newEl = document.createElement('select');
                        var option0 = document.createElement('option');
                        var option1 = document.createElement('option');
                        var option2 = document.createElement('option');

                        option1.text = "X";
                        option1.value = '2';
                        option2.text = "O";
                        option2.value = '1';
                        newEl.appendChild(option0);
                        newEl.appendChild(option1);
                        newEl.appendChild(option2);

                        if(originalContent[cell.id]=="O")
                        {
                            newEl.value = '1';
                            newEl.text = "O";
                        }
                        else if(originalContent[cell.id]=="X")
                        {
                            newEl.value = '2';
                            newEl.text = "X";
                        }
                    }
                    else
                    {
                        newEl = document.createElement('input');
                        newEl.value = originalContent[cell.id];
                    }
                    newEl.classList.add('edit_area4detail');
                    cell.appendChild(newEl);
                
                });

            });
                            
            buttonType21.addEventListener('click', function(e) {
                var table = e.target.closest('table');
                var editedCells = table.querySelectorAll('.edit_area4detail');
                updatedata4detail(editedCells, table)
                    .then(function() {
                        buttonType21.classList.add("hidden");
                        buttonType22.classList.add("hidden");
                        buttonType11.classList.remove("hidden");
                        buttonType12.classList.remove("hidden");

                        for (var i = 0; i < editedCells.length; i++)
                        {
                            var editedCell = editedCells[i];
                            var newDetailText = editedCell.value.trim();
                            var newCell = editedCell.parentElement;
                            console.log('newCell value: ', newCell.id);
                            if(newCell.id=='tool')
                            {
                                if(newDetailText=="1")
                                {
                                    newCell.textContent = "O";
                                }
                                else if(newDetailText=="2")
                                {
                                    newCell.textContent = "X";
                                }
                                else
                                {
                                    newCell.textContent = null;
                                }
                            }
                            else
                            {
                                newCell.textContent = newDetailText;
                            }
                        }
                    })
                    .catch(function(error) {
                        console.log('에러: ', error);
                    });
            });

            buttonType22.addEventListener('click', function() {
                // var cancleCells = document.getElementsByClassName('edit_area4detail'); // 안됨. 분명 11개 가져왔다고 뜨는데 정작 길이와 실제 적용가능한 건 4~5개다 심지어 같은 줄의 td다. 왜? 진짜 원리를 모르겠다...
                var cancleCells = document.querySelectorAll('.edit_area4detail');
                
                console.log(cancleCells);

                for (var i = 0; i < cancleCells.length; i++) {
                    var cancleCell = cancleCells[i];
                    var oldCell = cancleCell.parentElement;

                    oldCell.textContent = originalContent[oldCell.id];
                }

                buttonType21.classList.add("hidden");
                buttonType22.classList.add("hidden");
                buttonType11.classList.remove("hidden");
                buttonType12.classList.remove("hidden");
            });
        });


        // var buttonType11 = document.querySelector("#createUpdateForm");
        // var buttonType12 = document.querySelector("#back2list");
        // var buttonType21 = document.querySelector("#updateDetail");
        // var buttonType22 = document.querySelector("#cancle2update");
    
        // buttonType11.addEventListener('click', function(e) {                    
        //     var table = e.target.closest('table');
        //     var editableCells = table.querySelectorAll('.detail_value');

        //     buttonType11.classList.add("hidden");
        //     buttonType12.classList.add("hidden");
        //     buttonType21.classList.remove("hidden");
        //     buttonType22.classList.remove("hidden");

        //     editableCells.forEach(function(cell) {

        //         originalContent[cell.id] = cell.textContent.trim();
        //         cell.innerHTML = '';
        //         var newEl;
        //         if (cell.id==="note" || cell.id==="diskmodel" )
        //         {
        //             newEl = document.createElement('textarea');
        //             newEl.value = originalContent[cell.id];
        //         }
        //         else if(cell.id === "tool")
        //         {
        //             newEl = document.createElement('select');
        //             var option0 = document.createElement('option');
        //             var option1 = document.createElement('option');
        //             var option2 = document.createElement('option');

        //             option1.text = "X";
        //             option1.value = '2';
        //             option2.text = "O";
        //             option2.value = '1';
        //             newEl.appendChild(option0);
        //             newEl.appendChild(option1);
        //             newEl.appendChild(option2);

        //             if(originalContent[cell.id]=="O")
        //             {
        //                 newEl.value = '1';
        //                 newEl.text = "O";
        //             }
        //             else if(originalContent[cell.id]=="X")
        //             {
        //                 newEl.value = '2';
        //                 newEl.text = "X";
        //             }
        //         }
        //         else
        //         {
        //             newEl = document.createElement('input');
        //             newEl.value = originalContent[cell.id];
        //         }
        //         newEl.classList.add('edit_area4detail');
        //         cell.appendChild(newEl);
            
        //     });

        // });
                        
        // buttonType21.addEventListener('click', function() {
        //     var editedCells = document.querySelectorAll('.edit_area4detail');
        //     updatedata4detail(editedCells)
        //         .then(function() {
        //             buttonType21.classList.add("hidden");
        //             buttonType22.classList.add("hidden");
        //             buttonType11.classList.remove("hidden");
        //             buttonType12.classList.remove("hidden");

        //             for (var i = 0; i < editedCells.length; i++)
        //             {
        //                 var editedCell = editedCells[i];
        //                 var newDetailText = editedCell.value.trim();
        //                 var newCell = editedCell.parentElement;
        //                 console.log('newCell value: ', newCell.id);
        //                 if(newCell.id=='tool')
        //                 {
        //                     if(newDetailText=="1")
        //                     {
        //                         newCell.textContent = "O";
        //                     }
        //                     else if(newDetailText=="2")
        //                     {
        //                         newCell.textContent = "X";
        //                     }
        //                     else
        //                     {
        //                         newCell.textContent = null;
        //                     }
        //                 }
        //                 else
        //                 {
        //                     newCell.textContent = newDetailText;
        //                 }
        //             }
        //         })
        //         .catch(function(error) {
        //             console.log('에러: ', error);
        //         });
        // });

        // buttonType22.addEventListener('click', function() {
        //     // var cancleCells = document.getElementsByClassName('edit_area4detail'); // 안됨. 분명 11개 가져왔다고 뜨는데 정작 길이와 실제 적용가능한 건 4~5개다 심지어 같은 줄의 td다. 왜? 진짜 원리를 모르겠다...
        //     var cancleCells = document.querySelectorAll('.edit_area4detail');
            
        //     console.log(cancleCells);

        //     for (var i = 0; i < cancleCells.length; i++) {
        //         var cancleCell = cancleCells[i];
        //         var oldCell = cancleCell.parentElement;

        //         oldCell.textContent = originalContent[oldCell.id];
        //     }

        //     buttonType21.classList.add("hidden");
        //     buttonType22.classList.add("hidden");
        //     buttonType11.classList.remove("hidden");
        //     buttonType12.classList.remove("hidden");
        // });
    // }
}





function extraBoardForm (data) {
    var arrayIDData = [];
    
    for (var i = 0; i < data.length; i++)
    {
        var date = data[i];
        
        var a = parseInt(date.textContent);
        arrayIDData.push(a);
    }
    var tmp = data[0];
    var mxNum = arrayIDData.reduce(function(a, b) {
        return Math.max(a, b);
    });
    var reqNum = mxNum + 1;
    var sid = tmp['sid'];

    return new Promise(function(resolve, reject) {
        var xhr = new XMLHttpRequest();
        var extURL = "table.php?newid=" + reqNum + "&sid=" + sid;
        xhr.open('GET', extURL, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == XMLHttpRequest.DONE) {
                if (xhr.status == 200) {
                    console.log('sending data: ' + xhr.responseText); // debugging
                    var responsetext = this.responseText;
                    var tempDiv = document.createElement("div");
                    tempDiv.innerHTML = responsetext;
                    var content = tempDiv.querySelector(".board_area_new").innerHTML;
                    document.getElementById("extraBoardArea").innerHTML = '';
                    document.getElementById("extraBoardArea").innerHTML = content;
                    console.log("CONTENT: ")
                    console.log(content);
                    resolve(content);
                } else {
                    reject(xhr.statusText);
                    console.error('Error occurred: ' + xhr.status);
                }
            }
        };
        xhr.onerror = function() {
            reject(xhr.statusText); // Network error
        };
        xhr.send();
    });
}

function extraBoard()
{
    var data = document.querySelectorAll('.superHidden th');
    extraBoardForm(data)
        .then(function() {
            editEvent4detail("3");
        })
        .catch(function(error) {
            console.log('페이지 갱신 중 에러');
        });
}





function deleteEvent(a)
{
    console.log("deleteEvent: ", a);

    checkEvent4delete();

    var deletebutton=document.querySelector('input[type="button"].submitfordelete');
    if(deletebutton){
        deletebutton.addEventListener("click", handleDeleteClick);
    }
}

function checkEvent4delete()
{
    var data = [];
    var checkboxes = document.getElementsByClassName("checkboxClassName");
    for(var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].addEventListener("change", function(e) {
            var rowId = e.target.closest('tr').id;
            if (e.target.checked) {
                data.push(rowId); // 선택된 경우 배열에 추가
            } else {
                var index = data.indexOf(rowId);
                if (index !== -1) {
                    data.splice(index, 1); // 선택이 해제된 경우 배열에서 제거
                }
            }
            console.log("선택된 행의 ID:", data);
        });
    }
}

function datarray4delete() {        
    var checkbox = document.getElementsByClassName('checkboxClassName');
    var checkedTrId;
    var Idarray = [];

    // checkbox의 개수만큼 반복하면서 체크된 checkbox가 속한 td의 부모인 tr의 id 값을 찾음
    for (var i = 0; i < checkbox.length; i++) {
        if (checkbox[i].checked) {
            // 체크된 checkbox가 속한 td의 부모인 tr의 id 값을 가져와서 변수에 저장
            checkedTrId = checkbox[i].closest('tr').id;
            console.log("체크된 td가 속한 tr의 id 값: " + checkedTrId);
            Idarray.push(checkedTrId);
        }
    }
    return Idarray;
}

function handleButtonClick() {
    submitDataForCreate('1');
}

function handleKeyPress(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        submitDataForCreate('1');
        // e.stopPropagation();
    }
}

function handleDeleteClick() {
    submitDataForDelete();
}

function handleKey2cancle(e) {
    if(e.key === 'Escape')
    {
        submitDataForCreate();
    }
}

function handleClick2Cancle() {
    submitDataForCreate();
}

function submitDataForCreate(a) {
    if(a) {
        createdata()
            .then(refreshContent)
            .then(function() {
                editEvent('2');
                editEvent4detail('2');
                deleteEvent('2');
                document.getElementById("submitButton").addEventListener("click", handleButtonClick);
                document.getElementById("cancleSubmitButton").addEventListener("click", handleClick2Cancle);
                document.getElementById("cForm").addEventListener("keypress", handleKeyPress, true);
                document.getElementById("cForm").addEventListener("keydown", handleKey2cancle);
            })
            .catch(function(error) {
                var catchStringSN = "'sn'";
                var catchStringPID = "'pid'";
                var catchStringNAME = "Field 'name'";
                var catchStringDuplicatedNAME = "Duplicate entry";

                console.log(error);
                if(typeof error == "string")
                {
                    if(error.includes(catchStringSN))
                    {
                        alert('S/N는 중복 입력 할 수 없습니다.');
                    }
                    else if(error.includes(catchStringPID))
                    {
                        alert('업체가 할당되지 않았습니다.');
                    }
                    else if(error.includes(catchStringNAME))
                    {
                        alert('업체명을 작성해주세요.');
                    }
                    else if(error.includes(catchStringDuplicatedNAME) && error.includes("for key 'name'"))
                    {
                        alert('중복된 업체명이 있습니다.');
                    }
                    else
                    {
                        alert('update에 실패했습니다.');
                    }
                }
            });
    } else {
        refreshContent()
            .then(function() {
                editEvent('2');
                editEvent4detail('2');
                deleteEvent('2');
                document.getElementById("submitButton").addEventListener("click", handleButtonClick);
                document.getElementById("cancleSubmitButton").addEventListener("click", handleClick2Cancle);
                document.getElementById("cForm").addEventListener("keypress", handleKeyPress, true);
                document.getElementById("cForm").addEventListener("keydown", handleKey2cancle);
            })
            .catch(function(error) {
                console.log('페이지 갱신 중 에러');
            });
    }
}

function submitDataForDelete() {
    var selectedIds = datarray4delete();

    console.log("in submitDataForDelete(): ", selectedIds);
    console.log("length in submitDataForDelete(): ", selectedIds.length);


    if (selectedIds.length != 0)
    {
        if(confirm("삭제하시겠습니까?"))
        {
            deletedata(selectedIds)
            .then(refreshContent)
            .then(function() {
                editEvent('2');
                editEvent4detail('2');
                deleteEvent('2');
                document.getElementById("submitButton").addEventListener("click", handleButtonClick);
                document.getElementById("cancleSubmitButton").addEventListener("click", handleClick2Cancle);
                document.getElementById("cForm").addEventListener("keypress", handleKeyPress, true);
                document.getElementById("cForm").addEventListener("keydown", handleKey2cancle);
            })
            .catch(function(error) {
                console.log('페이지 갱신 중 에러');
            });
        }
        else
        {
            console.log('취소했습니다.');
        }
    }
    else
    {
        alert('삭제할 인벤토리를 선택해주세요.');
    }
}

function submitDetailDataForDelete(data)
{
    console.log(data);
    
    deletedata(data)
        .then(function() {
            location.reload();
        })
        .catch(function(error) {
            console.log('페이지 갱신 중 에러');
            console.error(error);
        });
}
// -- /functions -- //

// -- events -- //
document.addEventListener('DOMContentLoaded', function() {
    
    console.log('testtsetetsttest: ', window.location.pathname);

    // if (window.location.pathname === '/list/servers/') {}

    // refreshContent()
    //     then(function() {
    //         editEvent('1');
    //         deleteEvent('1');
    //         editEvent4detail('1');
            
    //         var submitButtonEl = document.getElementById("submitButton");
    //         if(submitButtonEl) {
    //             submitButtonEl.addEventListener("click", handleButtonClick);
    //         }
        
    //         var cFormEl = document.getElementById("cForm");
    //         if(cFormEl){
    //             cFormEl.addEventListener("keypress", handleKeyPress);
    //             cFormEl.addEventListener("keydown", handleKey2cancle);
    //         }
        
    //         var redmineIF = document.getElementById('redmineInFirstPage');
    //         if(redmineIF){
    //             console.log("connecting Redmine...");
    //             redmineIF.addEventListener("click", function(e) {
    //                 e.preventDefault();
    //                 connectRedmine('/projects');
    //             })
    //         }
    //     })
    //     .catch(function(error) {
    //         console.log('에러: ', error);
    //     });

    editEvent('1');
    deleteEvent('1');
    editEvent4detail('1');
    
    var submitButtonEls = document.querySelectorAll("#submitButton");
    if(submitButtonEls)
    {
        submitButtonEls.forEach(function(el) {
            var submitButtonEl = el;
            submitButtonEl.addEventListener("click", handleButtonClick);
        });
    }
    
    var cancleSubmitButtonEls = document.querySelectorAll("#cancleSubmitButton");
    if(cancleSubmitButtonEls)
    {
        cancleSubmitButtonEls.forEach(function(el) {
            var cancleSubmitButtonEl = el;
            cancleSubmitButtonEl.addEventListener("click", handleClick2Cancle);
        });
    }

    var cFormEl = document.getElementById("cForm");
    if(cFormEl)
    {
        cFormEl.addEventListener("keypress", handleKeyPress, true);
        cFormEl.addEventListener("keydown", handleKey2cancle);
    }

    var redmineIF = document.getElementById('redmineInFirstPage');
    if(redmineIF)
    {
        console.log("connecting Redmine...");
        redmineIF.addEventListener("click", function(e) {
            e.preventDefault();
            connectRedmine('/projects');
        });
    }
});
// -- /event -- //