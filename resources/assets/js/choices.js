(function() {
    var createField = function(name, count) {
        var nameLowerCount = name.toLowerCase() + count;

        var label = $('<label>')
                    .prop('for', nameLowerCount).text(name + " " + count);

        var input = $('<input>')
                    .prop({'type': 'text', 'name': "choices[]", 'id': nameLowerCount, 'class': 'form-control'});

        var unit = $('<div>')
                    .prop({'id': nameLowerCount, 'class': 'form-group'})
                    .append(label)
                    .append(input);

        return unit;
    };

    var count = 2;

    $('button#add-choice').on('click', function() {
        count++;
        var choiceField = createField("Choice", count);
        $('div.choices').append(choiceField);
        $('button#add-choice').appendTo('div.choices div:last-child');

    });
})();
