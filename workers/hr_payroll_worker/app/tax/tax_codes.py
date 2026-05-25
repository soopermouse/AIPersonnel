class TaxCodeEngine:
    def calculate(self, country_code: str, gross: float, tax_code: str | None = None) -> dict:
        country = country_code.upper()

        # Scaffold rates only. Replace with verified live tax tables before production.
        if country == "NL":
            employee_rate = 0.28
            employer_rate = 0.18
        elif country == "UK":
            employee_rate = 0.25
            employer_rate = 0.138
        elif country == "US":
            employee_rate = 0.22
            employer_rate = 0.0765
        else:
            employee_rate = 0.25
            employer_rate = 0.15

        return {
            "country_code": country,
            "tax_code": tax_code,
            "employee_tax": round(gross * employee_rate, 2),
            "employer_tax": round(gross * employer_rate, 2),
            "notes": "Scaffold estimate only; plug in verified NL/UK/US payroll tables.",
        }