# AI Coding Agent Instructions for ATKFlow

> Status: This repository currently has no tracked source files or configuration. These instructions focus on how to get oriented and what to confirm with the user before making structural decisions.

## 1. Current State & Assumptions
- The workspace root is `ATKFlow`, but the folder is effectively empty (no README, build files, or source directories were detected).
- Do not invent architecture, tech stack, or workflows; ask the user to confirm the intended stack (e.g., Python, Node, .NET) before scaffolding anything substantial.
- Treat any new files you create as proposals that must align with the user’s described goals.

## 2. How to Get Oriented
- First, ask the user for:
  - Target language and framework (e.g., FastAPI backend, React frontend, etc.).
  - Deployment target (e.g., Docker, Azure, AWS, on-prem) if relevant.
  - Any existing design docs, diagrams, or prior repos ATKFlow should resemble.
- Once the user clarifies the stack, propose a minimal but realistic project layout and confirm it before generating many files.

## 3. Scaffolding New Projects
- Prefer idiomatic, standard layouts for the chosen stack (e.g., `src/` for code, `tests/` for tests) rather than inventing custom structures.
- Always include a top-level `README.md` that explains:
  - What ATKFlow is meant to do.
  - How to install dependencies.
  - How to run the app and tests.
- Create a single, clear entry point for the main app (e.g., `src/main.py`, `src/index.ts`, or `src/App.tsx`) and reference it in the README.

## 4. Build, Run, and Test Workflows
- After the stack is chosen, add standard build/run/test commands via:
  - `package.json` scripts for Node/TypeScript projects.
  - `pyproject.toml` or `requirements.txt` + a `Makefile`/`invoke`/`nox`/`tox` command for Python projects.
  - Appropriate project files for other ecosystems (e.g., .NET, Java, Rust).
- Document all primary workflows in the README (e.g., `npm run dev`, `python -m app`, `dotnet run`).
- When adding tests, keep them in a dedicated tests folder and mirror the app structure.

## 5. Patterns and Conventions to Establish
- Use clear, descriptive names for modules and directories that reflect ATKFlow’s domain (e.g., `workflows/`, `tasks/`, `integrations/`) once the user defines the problem space.
- Centralize configuration (e.g., `config/` or `settings/` modules) instead of scattering hard-coded values.
- Prefer dependency injection or explicit parameter passing over hidden globals for any cross-cutting services (e.g., logging, database, messaging).

## 6. Collaboration with the User
- Before large refactors or generating many files, summarize the planned structure and get user approval.
- If the user opens or mentions existing files not visible in this workspace (e.g., from another repo), align new code with those patterns.
- Keep changes minimal and focused on the user’s current request; avoid introducing extra layers or frameworks beyond what they’ve asked for.

## 7. Updating These Instructions
- As the codebase grows, update this file to document:
  - Actual architecture (key directories, services, and data flow).
  - Real build/test commands.
  - Any project-specific conventions that emerge.
- Avoid generic best practices here; only record patterns that are actually used in ATKFlow.
