from app.domain.models import ModuleJobRequest, ModuleJobResult


class ModuleRouter:
    def route(self, module_code: str, request: ModuleJobRequest) -> ModuleJobResult:
        # Base gateway only. Specialised workers/modules will be added one at a time.
        known_modules = {
            "nxd_tax": "Tax module placeholder",
            "sales": "Sales module placeholder",
            "inventory": "Inventory module placeholder",
            "daily_reports": "Daily reports placeholder",
        }

        if module_code not in known_modules:
            return ModuleJobResult(
                module_code=module_code,
                job_type=request.job_type,
                status="unknown_module",
                warnings=[f"Module '{module_code}' is not registered in the gateway yet."],
            )

        if request.job_type == "healthcheck":
            return ModuleJobResult(
                module_code=module_code,
                job_type=request.job_type,
                status="ok",
                result={
                    "message": known_modules[module_code],
                    "payload_received": request.payload,
                },
            )

        return ModuleJobResult(
            module_code=module_code,
            job_type=request.job_type,
            status="not_implemented",
            result={
                "message": f"{module_code} worker exists as placeholder. Implement job type next.",
                "payload_received": request.payload,
            },
        )