from app.domain.models import PayrollCalculationRequest, PayrollCalculationResult
from app.tax.tax_codes import TaxCodeEngine

class PayrollCalculator:
    def calculate(self, request: PayrollCalculationRequest) -> PayrollCalculationResult:
        gross_total = 0.0
        employee_tax_total = 0.0
        employer_tax_total = 0.0
        benefits_total = 0.0
        details = []
        tax_engine = TaxCodeEngine()

        for employee in request.employees:
            if employee.employment_type == "temp_hourly":
                gross = employee.hourly_rate * employee.hours_worked
            else:
                gross = employee.monthly_wage

            pension = float(employee.benefits.get("pension", 0) or 0)
            travel = float(employee.benefits.get("travel_expenses", 0) or 0)
            holidays = float(employee.benefits.get("holidays", 0) or 0)
            benefits = pension + travel + holidays

            taxes = tax_engine.calculate(employee.country_code, gross, employee.tax_code)

            gross_total += gross
            employee_tax_total += taxes["employee_tax"]
            employer_tax_total += taxes["employer_tax"]
            benefits_total += benefits

            details.append({
                "name": employee.name,
                "gross": round(gross, 2),
                "employee_tax": taxes["employee_tax"],
                "employer_tax": taxes["employer_tax"],
                "benefits": round(benefits, 2),
                "net": round(gross - taxes["employee_tax"], 2),
                "tax_notes": taxes["notes"],
            })

        return PayrollCalculationResult(
            period=request.period,
            country_code=request.country_code,
            gross_pay=round(gross_total, 2),
            employee_taxes=round(employee_tax_total, 2),
            employer_taxes=round(employer_tax_total, 2),
            benefits_cost=round(benefits_total, 2),
            net_pay=round(gross_total - employee_tax_total, 2),
            details=details,
        )