import React, { PropTypes } from 'react';

const defaultAmounts = [500, 200, 100, 70, 50, 20, 10];

export default class AmountChooser extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            amount: props.value,
        };

        this.handleButtonClicked = this.handleButtonClicked.bind(this);
        this.handleInputChange = this.handleInputChange.bind(this);
        this.handleInputKeyPress = this.handleInputKeyPress.bind(this);
    }

    handleButtonClicked(amount) {
        if (this.props.onChange) {
            this.props.onChange(amount);
        }

        this.refs.other_amount.value = '';

        this.setState({
            amount,
        });
    }

    handleInputChange(event) {
        if (this.props.onChange) {
            this.props.onChange(event.target.value);
        }

        this.setState({
            amount: event.target.value,
        });
    }

    handleInputKeyPress(event) {
        if (!this.props.onSubmit) {
            return;
        }

        const key = event.keyCode || event.charCode;

        if (13 === key) {
            event.preventDefault();
            this.props.onSubmit();
        }
    }

    render() {
        const state = this.state.amount;
        const classSelected = 'amount-chooser__button--selected';

        return (
            <div className="amount-chooser">
                <input type="hidden" name={this.props.name} value={state} />

                {defaultAmounts.map(amount => (
                    <button className={`amount-chooser__button ${amount === state ? classSelected : ''}`}
                            type="button"
                            onClick={() => this.handleButtonClicked(amount)}
                            key={`amount_${amount}`}>
                        {amount}€
                    </button>
                ))}

                <div className="amount-chooser__other">
                    <input
                        type="number"
                        className="amount-chooser__other__input"
                        id="amount-chooser__other__input"
                        placeholder="Autre"
                        min="0.01"
                        max="7500"
                        step="0.01"
                        ref="other_amount"
                        onFocus={this.handleInputChange}
                        onChange={this.handleInputChange}
                        onKeyPress={this.handleInputKeyPress}
                        defaultValue={-1 < defaultAmounts.indexOf(this.props.value) ? null : this.props.value} />

                    <label htmlFor="amount-chooser__other__input"
                           className="amount-chooser__other__label">
                        <span>Entrez un autre montant</span>
                        €
                    </label>
                </div>

                <h3 className="b__nudge--top-large b__nudge--bottom-tiny">Don récurrent</h3>
                <div className="text--left">
                    En cochant la case ci-dessous, vous acceptez de mensualiser
                    ce don. Votre carte bancaire sera débitée tous les mois. Vous
                    pouvez annuler ce don mensuel à tout moment depuis votre
                    espace adhérent ou en nous contactant.
                </div>
                <div className="amount-chooser__monthly form__checkbox form__checkbox--large">
                    <input type="checkbox" name="abonnement" id="donation-monthly"/>
                    <label htmlFor="donation-monthly" id="donation-monthly_label">
                        Je veux donner ce montant chaque mois
                    </label>
                </div>
                <div className="amount-chooser__help">

                </div>
            </div>
        );
    }
}

AmountChooser.propTypes = {
    name: PropTypes.string.isRequired,
    value: PropTypes.number,
    onChange: PropTypes.func,
    onSubmit: PropTypes.func,
};
