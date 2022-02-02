import Choices from 'choices.js';

class Select {
  constructor(el, settings) {
    const settingsDefault = {
      removeItemButton: true,
      paste: false,
      searchChoices: false,
      classNames: {
        containerOuter: 'form__control',
        containerInner: 'form__select',
        list: 'form__list',
        listItems: 'form__list--multiple',
        listSingle: 'form__list--single',
        listDropdown: 'form__list--dropdown',
        item: 'form__item',
        itemSelectable: 'form__item--selectable',
        itemDisabled: 'form__item--disabled',
        itemChoice: 'form__item--choice',
        input: 'form__input',
        inputCloned: 'form__input--cloned',
        button: 'form__remove',
        itemSelectText: '',
      },
    };

    this.select = new Choices(el, {
      ...settingsDefault,
      ...settings,
    });
  }

  setChoice(val) {
    this.select.setChoiceByValue(val);
  }
}

export default Select;
