import Sortable from 'sortablejs';

(function() {
  'use strict';
  var junta = document.getElementById('asifa-list-junta');
  var equipo = document.getElementById('asifa-list-equipo');
  var asociados = document.getElementById('asifa-list-asociados');
  var ms = 100;

  function updateOrder(target) {
    var items = target.querySelectorAll('li');

    for (var i = 0; i < items.length; i++) {
      var item = items[i];
      var orderInput = item.querySelector('.order');
      orderInput.value = i + 1;
    }
  }

  function onUpdate(e) {
    updateOrder(e.target);
  }

  function onAdd(e) {
    var target = e.target;
    var group = target.dataset.group;
    var item = e.item;
    var source = e.from;
    var groupInput;

    if (target.id !== 'asifa-list-asociados') {
      var inputs = item.querySelectorAll('input');
      for (var i = 0; i < inputs.length; i++) {
        inputs[i].disabled = false;
      }
    }

    groupInput = item.querySelector('.group');
    groupInput.value = group;
    updateOrder(target);
  }

  function cleanData(e) {
    var item = e.item;
    item.querySelector('.group').value = '';
    item.querySelector('.order').value = '';
  }

  if (asociados) {
    Sortable.create(asociados, {
      group: {
        name: 'asociados',
        put: ['junta', 'equipo']
      },
      sort: false,
      animation: ms,
      onAdd: cleanData
    });
  }

  if (junta) {
    Sortable.create(junta, {
      group: {
        name: 'junta',
        put: ['equipo', 'asociados']
      },
      animation: ms,
      onAdd: onAdd,
      onUpdate: onUpdate
    });
  }

  if (equipo) {
    Sortable.create(equipo, {
      group: {
        name: 'equipo',
        put: ['junta', 'asociados']
      },
      animation: ms,
      onAdd: onAdd,
      onUpdate: onUpdate
    });
  }
})();
