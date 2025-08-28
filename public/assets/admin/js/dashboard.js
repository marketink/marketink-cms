$(document).on('click', '.close-modal', function () {
    const modal = $(this).parents('.modal');
    modal.modal('toggle')
});

let contents = [];
let content = null;

function resetForm(self, mediaStatus = false) {
    self.reset();
    $(self).removeAttr('actioned');
    $(self).find('.methoded').remove();
    $(self).find('.is-filled').removeClass('is-filled');
    if (mediaStatus) {
        $(self).find('.file_id').remove();
        for (var dropzone of dropzones) {
            //dropzone.dropzone.hide();
            //dropzone.dropzone = new Dropzone(dropzone.elm, dropzone.option)
            //dropzone.dropzone.removeAllFiles(true);
            $(dropzone.dropzone.element).find('.dz-preview').addClass('hidden');
            $(dropzone.dropzone.element).removeClass('dz-started')
        }
    }
}

$(document).on('click', '.open-modal', function () {
    const modal = $($(this).data('target'));
    modal.find('form').each(function () {
        resetForm(this, true)
    });
    modal.modal('toggle');
});

const tables = {};
const forms = {
    success: {
        files: function (data) {

        },
        users: function (data, elm) {
            $(elm).parents('.modal').modal('hide');
            tables['users'].ajax.reload();
            forms.success.default(data, elm);
        },
        contents: function (data, elm) {
            $(elm).parents('.modal').modal('hide');
            tables['contents'].ajax.reload();
            forms.success.default(data, elm);
        },
        setting: function (data, elm) {
            Toastify({
                text: data.message,
                duration: 3000,
                gravity: "top",
                position: "right",
                backgroundColor: "#4CAF50",
                stopOnFocus: true,
            }).showToast();
        },
        cart: function (data) {
            Toastify({
                text: data.message,
                duration: 3000,
                gravity: "top",
                position: "right",
                backgroundColor: "#4CAF50",
                stopOnFocus: true,
            }).showToast();
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        },
        default: function (data, elm) {
            resetForm($(elm)[0], true);
            Toastify({
                text: data.message,
                duration: 3000,
                gravity: "top",
                position: "right",
                backgroundColor: "#4CAF50",
                stopOnFocus: true,
            }).showToast();
            smartForm();
        }
    },
    error: {
        files: function (data, elm) {
            forms.error.default(data, elm);
        },
        contents: function (data) {
            forms.error.default(data, elm);
        },
        users: function () {
            forms.error.default(data, elm);
        },
        default: function (data) {
            Toastify({
                text: data.message,
                duration: 3000,
                gravity: "top",
                position: "right",
                backgroundColor: "#f44336",
                stopOnFocus: true,
            }).showToast();
        }
    }
}


$(document).on('click', '.remove', function () {
    var url = $(this).data('url');
    confirmDialog(url);
});

function confirmDialog(url, data, success, error) {
    $('.confirm-backdrop, .confirm').remove();
    const time = new Date().getTime();
    $('body').append(`
        <div class="confirm-backdrop"></div>
        <div class="confirm" time="${time}">
            <h1>حذف آیتم</h1>
            <p>آیا از حذف این آیتم مطمئن هستید؟</p>
            <button class="confirm-item" data-url="${url}" style="color:red" autofocus>حذف</button>
            <button class="cancel-item" autofocus>بستن</button>
        </div>    
    `);

    $(document).on('click', `.confirm[time="${time}"] .cancel-item`, function () {
        $('.confirm-backdrop, .confirm').remove();
    })

    $(document).on('click', `.confirm[time="${time}"] .confirm-item`, function () {
        $('.confirm-backdrop, .confirm').remove();
        var url = $(this).data('url');
        var d = {
            ...data,
            _method: "delete"
        };
        $.ajax({
            url,
            method: "post",
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            data: d,
            success, error
        });
    })
}

$(document).on('click', '.remove-relation', function () {
    var parent_id = $(this).data('parent-id');
    var child_id = $(this).data('child-id');
    var self = this;
    confirmDialog(`/admin/dashboard/contents/relations`, {
        parent_id, child_id
    }, function () {
        $(self).parents('.form-check').remove();
        for (var table of Object.keys(tables)) {
            tables[table].ajax.reload();
        }
    });
});

$(document).on('click', '.edit-table-item', function () {
    var id = $(this).data('id');
    var url = $(this).data('url');
    var table = $(this).data('table');
    const modal = $(`.modal[data-table="${table}"]`)
    const form = modal.find('.main-form');
    resetForm(form[0], true);
    form.attr('actioned', url);
    $.ajax({
        url,
        success: function (data) {
            if (table != "contents") {
                fillForm(data.data, form[0]);
                modal.modal('toggle');
            } else {
                var items = data.data;
                var inputs = [];
                var labelI = 0;
                for (var label of items.texts) {
                    ++labelI;
                    inputs.push({
                        key: `texts[${labelI}][text]`,
                        value: label.text
                    });
                }
                for (var price of items.prices) {
                    inputs.push({ key: `price`, value: Number(price.price).toLocaleString('en-US') });
                    inputs.push({ key: `currency`, value: price.currency });
                    inputs.push({ key: `discount`, value: price.discount });
                }
                inputs.push({ key: `stock`, value: items.stock });
                items.files.forEach(file => {
                    const mockFile = {
                        name: file.path,
                        size: file.size,
                        accepted: true
                    };
                    for (var dropzone of dropzones.filter(e => e.type == file.type)) {
                        var myDropzone = dropzone.dropzone;
                        myDropzone.emit("addedfile", mockFile);
                        myDropzone.emit("thumbnail", mockFile, file.link);
                        myDropzone.emit("complete", mockFile);

                        const removeButton = mockFile.previewElement.querySelector(".dz-remove");
                        if (removeButton) {
                            removeButton.addEventListener("click", (e) => {
                                e.preventDefault();
                                e.stopPropagation();
                                removeFile(mockFile.name, form);
                            });
                        }
                        myDropzone.files.push(mockFile);
                    }
                    form.append(`<input type="hidden" name="files[]" class="file_id" value="${file.id}" />`)
                });

                fillFormByData({
                    checked: items.parents.map(function (item) {
                        return `relations[${item.type}][${item.id}]`;
                    }),
                    selected: [
                        {
                            key: "status",
                            value: items.status
                        }
                    ],
                    inputs: inputs
                }, form);
                modal.modal('toggle');
            }
            form.append(`<input type="hidden" name="_method" class="methoded" value=PUT />`);
        }
    });
});

function fillFormByData(data, form) {
    var checkboxs = data.checked;
    for (var checkbox of checkboxs) {
        form.find(`[name="${checkbox}"]`).prop('checked', true)
    }
    var selecteds = data.selected;
    for (var select of selecteds) {
        $(form).find(`select[name="${select.key}"] option`).filter(function () {
            return $(this).text().trim() === select.value;
        }).prop('selected', true);
    }
    var inputs = data.inputs;
    for (var input of inputs) {
        var parent = $(form).find(`[name="${input.key}"]`).parents('.input-group');
        parent.addClass('input-group input-group-outline my-3 is-filled')
        $(form).find(`[name="${input.key}"]`).val(input.value);
    }

}

$(document).on('click', '.remove-table-item', function () {
    var id = $(this).data('id');
    var url = $(this).data('url');
    var table = $(this).data('table');
    var self = this;
    confirmDialog(url, {
        id
    }, function () {
        smartForm();
        tables[table].ajax.reload();
    });
})


function setFormValue(form, name, value) {
    const element = form.querySelector(`[name="${name}"]`);
    if (!element) return;

    if (element.type === 'checkbox') {
        element.checked = Boolean(value);
    } else if (element.tagName === 'SELECT' || element.tagName === 'TEXTAREA' || ['text', 'email', 'number', 'int'].includes(element.type)) {
        element.value = value;
    }
}

function traverseAndFill(form, data, prefix = '') {
    for (const key in data) {
        if (!data.hasOwnProperty(key)) continue;
        const value = data[key];
        const newPrefix = prefix ? `${prefix}[${key}]` : key;
        console.log(key, value, newPrefix)

        if (typeof value === 'object' && value !== null && !Array.isArray(value)) {
            traverseAndFill(form, value, newPrefix);
        } else {
            setFormValue(form, newPrefix, value);
        }
    }
}


function smartForm() {

    function appendRelation(result, elm) {
        var pivot = result.pivot ? `
            <p class="remove-relation" data-parent-id="${result.pivot.parent_id}" data-child-id="${result.pivot.child_id}">
                <i class="fa fa-trash"></i>
                <span>حذف وابستگی</span>
            </p>
        ` : "";
        elm.append(`
            <div class="smart-form-inputs" id="smart-form-inputs-${result.id}">
                <div class="form-check">
                    <input type="checkbox" value="${result.id}" name="relations[${result.type}][${result.id}]" class="form-check-input" id="smart-form-${result.id}" />
                    <label class="custom-control-label" for="smart-form-${result.id}">${result.info.title}</label>
                    ${pivot}
                </div>
            </div>
        `)
        if (result.relations.length > 0) {
            for (var relation of result.relations) {
                appendRelation(relation, elm.find(`#smart-form-inputs-${result.id}`))
            }
        }
    }

    $('.smart-form').each(function () {
        var url = $(this).attr('url');
        var self = this;
        $(self).empty();
        $.ajax({
            url,
            success: function (results) {
                if (results.data.length > 0) {
                    $(self).parents('.smart-form-init').removeClass('hidden');
                }
                for (var result of results.data) {
                    appendRelation(result, $(self))
                }
            }
        });
    })
}

function getNestedValue(obj, path) {
    return path.split('.').reduce((acc, part) => acc && acc[part], obj);
}

$(document).ready(function () {

    smartForm();

    $('.chart-init').each(function () {
        Chart.defaults.font.family = 'IRANSans';

        const ctx = $(this).find('canvas')[0].getContext("2d");
        const labels = String($(this).data('labels'));
        const allData = String($(this).data('data'));
        const data = {
            labels: labels.split(','),
            datasets: [{
                label: $(this).data('label'),
                tension: 0.4,
                borderWidth: 0,
                borderRadius: 4,
                borderSkipped: false,
                backgroundColor: $(this).data('background'),
                data: allData.split(','),
                barThickness: 'flex'
            },],
        };
        new Chart(ctx, {
            type: "bar",
            data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: '#e5e5e5'
                        },
                        ticks: {
                            suggestedMin: 0,
                            suggestedMax: 500,
                            beginAtZero: true,
                            padding: 10,
                            font: {
                                size: 14,
                                lineHeight: 2
                            },
                            color: "#737373"
                        },
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: '#737373',
                            padding: 10,
                            font: {
                                size: 14,
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });

    })

    $('.data-table').each(function () {
        const table = $(this);
        const elm = table.find('table');

        if (elm.length > 0) {
            const id = elm.data('id') ?? 'table';
            var dataReq = [];
            table.find('filter select, filter select').each(function () {
                var element = $(this);
                var name = element.attr('name');
                dataReq.push({
                    name, element: `#data-table-body-${id} [name='${name}']`
                })
            });
            const ajax = {
                url: elm.data('url'),
                data: function (d) {
                    for (var item of dataReq) {
                        d[item.name] = $(item.element).val()
                    }
                }
            };
            const cols = elm.find('thead tr th');
            const columns = cols.map(function (e) {
                const data = $(cols[e]);
                const name = data.attr('data');
                const nameAttr = data.attr('name') ?? name;

                const scope = data.attr('scope') ?? "";
                const scopes = scope.split(',');
                let result = {
                    data: name,
                    name: nameAttr,
                    className: ["id", "username"].find(e => e == name) ? 'text-bold' : '',
                    render: function (d, type, row, meta) {
                        var val = getNestedValue(row, name);
                        if (data.data('function')) {
                            val = eval(data.data('function'));
                        }
                        if (data.data('label')) {
                            var val2 = getNestedValue(row, data.data('label'))
                            val = `${val} <b><small>${val2}</small></b>`
                        }
                        return val;
                    }
                };
                if (name == "action") {
                    result = {
                        data: "id",
                        name: "id",
                        title: data.text(),
                        orderable: false,
                        searchable: false,
                        visible: true,
                        render: function (data, type, row, meta) {
                            var initURL = new URL(elm.data('url'));
                            var elms = "";
                            if (scopes.includes("edit")) {
                                elms = elms + `
                                <a href="javascript:;" class="mx-2 edit-table-item" data-id="${row.id}" data-url="${initURL.origin}${initURL.pathname}/${row.id}" data-table="${id}">
                                    <i class="fa fa-edit"></i>
                                </a>  
								`;
                            }
                            if (scopes.includes("show")) {
                                elms = elms + `
                                <a href="${initURL.origin}${initURL.pathname}/${row.id}" class="mx-2 show-table-item" data-id="${row.id}" data-url="${initURL.origin}${initURL.pathname}/${row.id}" data-table="${id}">
                                    <i class="fa fa-eye"></i>
                                </a>
								`;
                            }
                            if (scopes.includes("delete")) {
                                elms = elms + `
                                <a href="javascript:;" class="mx-2 remove-table-item" data-id="${row.id}" data-url="${initURL.origin}${initURL.pathname}/${row.id}" data-table="${id}">
                                    <i class="fa fa-trash"></i>
                                </a>
								`;
                            }
                            return elms;
                        }
                    }
                }
                return result;
            });

            elm.attr('id', `data-table-box-${id}`)

            tables[id] = elm.DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                pageLength: 10,
                lengthChange: false,
                ajax,

                columns,
                language: {
                    url: "/assets/admin/data-table-fa-lang.js",
                    search: '', // حذف کلمه "Search"
                    searchPlaceholder: 'جستجو کنید...',
                }
            });

            runDataTableFilter(id)
        }
    })

    $('.select-init').each(function () {
        const option = {};
        option.placeholder = $(this).attr('placeholder');
        if ($(this).data('url')) {
            option.ajax = {
                url: $(this).data('url'),
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: data.map(item => ({
                            id: item.id,
                            text: item.name
                        }))
                    };
                },
                cache: true
            }
        }
        $(this).select2(option);
    })

});

function runDataTableFilter(id) {
    setTimeout(() => {
        $(`#data-table-box-${id}_filter`).append(`${$(`#data-table-body-${id}`).find('filter').html() ?? ""}`);
        $(`#data-table-body-${id}`).find('filter').remove();

        const filters = $(`#data-table-box-${id}_filter`).find('select, input');
        filters.each(function () {
            $(this).on('change', function () {
                tables[id].ajax.reload();
            });
        })
    }, 500);
}

Array.prototype.chunk = function (size) {
    const result = [];
    for (let i = 0; i < this.length; i += size) {
        result.push(this.slice(i, i + size));
    }
    return result;
}

if (typeof (Dropzone) != "undefined") {
    Dropzone.autoDiscover = false;
}

var dropzones = [];

function removeFile(file_id, form) {
    fetch("/admin/api/files/" + file_id, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ id: file_id, _method: 'delete' })
    }).then(res => res.json())
        .then(function (response) {
            form.find(`.file_id[value="${response.id}"]`).remove();
        });
}

$(document).ready(function () {
    const elms = $('.dropzone');
    elms.each(function (item) {
        var elm = $(this);
        var dictDefaultMessage = elm.attr('title') ?? "فایل‌های خود را اینجا بکشید یا کلیک کنید";
        const option = {
            maxFilesize: 10, // MB
            acceptedFiles: "image/*",
            timeout: 1800000,
            addRemoveLinks: true,
            dictDefaultMessage,
            dictRemoveFile: "حذف فایل",
            dictCancelUpload: "لغو آپلود",
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            success: function (file, response) {
                var elm = $(file.previewElement);
                elm = elm.parents('.dropzone');
                elm = elm.parents('.modal-body');
                elm = elm.find('.content-submit-form');
                elm.append(`<input type="hidden" name="files[]" class="file_id" value="${response.id}" />`);
                file.uploadedPath = response.path;
            },
            error: function (file, response) {

            },
            uploadprogress: function (file, progress) {
                const progressElement = file.previewElement.querySelector(".dz-upload");
                if (progressElement) {
                    progressElement.style.width = progress + "%";
                }
            },
            removedfile: function (file) {
                if (file.uploadedPath) {
                    var file_id = file.uploadedPath;
                    var elm = $(file.previewElement);
                    elm = elm.parents('.dropzone');
                    elm = elm.parents('.modal-body');
                    elm = elm.find('.content-submit-form');
                    var form = elm;
                    removeFile(file_id, form);
                }
                const preview = file.previewElement;
                if (preview) preview.remove();
            }
        };
        const d = new Dropzone(`#${elm.attr('id')}`, option);
        dropzones.push({
            dropzone: d,
            option,
            type: elm.data('dropzone-type'),
            elm: `#${elm.attr('id')}`
        });
    })
});

function fillForm(data = null, form) {
    if (!data) return false;
    $(form).find('.input-group').addClass('input-group input-group-outline my-3 is-filled')
    Array.from(form.elements).forEach((element) => {
        const name = element.name;
        if (!name) return;
        const arrayLikeMatch = name.match(/^(\w+)\[(\w+)\]$/);
        if (arrayLikeMatch) {
            const mainKey = arrayLikeMatch[1];
            const subKey = arrayLikeMatch[2];
            if (data[mainKey] && data[mainKey][subKey] !== undefined) {
                element.value = data[mainKey][subKey];
            } else {
                element.value = '';
            }
        } else {
            if (data[name] !== undefined) {
                element.value = data[name];
            } else {
                element.value = '';
            }
        }
    });
}

$(document).on('click', '.send-form', function () {
    var form = $(this).data('form');
    form = $(form);
    form[0].requestSubmit()
});

$(document).on('click', '.input-tree', function () {
    var id = $(this).prop('checked');
    alert(id);
});

$(document).on('submit', 'form', function (e) {
    e.preventDefault();
    const elm = e.target;
    const success = $(elm).data('success');
    const error = $(elm).data('error');

    if (!elm.checkValidity()) {
        elm.reportValidity();
        return;
    }

    const formData = new FormData(elm);
    var url = $(this).attr('action');
    var actioned = $(this).attr('actioned') ?? null;
    var method = $(this).attr('method');

    if (formData.get("price")) {
        const rawPrice = formData.get("price").replace(/,/g, '');
        formData.set("price", rawPrice);
    }

    $.ajax({
        url: actioned ?? url,
        data: formData,
        method,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        success: function (response) {
            try {
                forms.success[success](response, elm);
            } catch (e) {
                forms.success.default(response, elm);
            }
        },
        error: function (response) {
            try {
                forms.error[error](response.responseJSON, elm);
            } catch (e) {
                forms.error.default(response.responseJSON, elm);
            }
        }
    });
});

$(document).on('input', 'input[type="int"]', function () {
    var val = this.value;
    val = val.replace(/[۰۱۲۳۴۵۶۷۸۹]/g, function (d) { return d.charCodeAt(0) - 1776; })
    val2 = val.replace(/[٠١٢٣٤٥٦٧٨٩]/g, function (d) { return d.charCodeAt(0) - 1632; }).replace(/[۰۱۲۳۴۵۶۷۸۹]/g, function (d) { return d.charCodeAt(0) - 1776; });
    this.value = val2;
    this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');
    var name = $(this).attr('name');
    if (name == "price") {
        let val = $(this).val().replace(/,/g, '');
        if (!/^\d*$/.test(val)) return;
        $(this).val(Number(val).toLocaleString('en-US'));
    }
});