/**
 * Form de adicionar/remover categorias
 */
export default class FormCategorias {
  constructor( $form ) {
    this.$form = $form;
    this.$inputs = $form.find('input:checkbox');
    this.saveCheckState();
  }

  saveCheckState() {
    this.$inputs.each(function() {
      $(this).data('checked', $(this).prop('checked'));
    });
  }

  reset() {
    this.$inputs.each(function() {
      $(this).prop('checked', $(this).data('checked'));
    });
  }

  getCheckedInputs() {
    return this.$inputs.filter(':checked');
  }

  getCategoriesMarkup() {
    var catsMarkup = '';

    this.getCheckedInputs().each(function() {
      var id = $(this).closest('.tab-pane').attr('id');
      var val = $(this).val();
      var text = $(this).siblings('span').text();

      catsMarkup += `
        <li class="cat-${id}">
          <input type="hidden" name="categorias[]" value="${val}">
          ${text}
          <button class="bt-delete">&times;</button>
        </li>
      `;
    });

    return catsMarkup;
  }
}
