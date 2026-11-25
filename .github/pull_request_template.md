## What and why

<!-- One or two sentences. The base branch is develop, never main. -->

Closes #

## How to test it

<!-- Steps for the tester, based on the acceptance criteria of the issue. -->

1. `git switch <this branch> && git pull` (the git hooks run `make update`)
2. Open the site (`make status` shows the URL) and …
3.

## How it was tested

```shell
make verify
```

## Screenshots

| Before | After |
| :----: | :---: |
|        |       |

## Checklist

- [ ] Acceptance criteria of the issue are met
- [ ] Steps for the tester are filled in
- [ ] `make verify` passes
- [ ] Visible text is in English and goes through `__('…')`
- [ ] No passwords, keys or personal data in code or commits
- [ ] Docs, README or `docs/erd.md` updated where needed

<!-- Merge only after the issue is on Approved, then move the issue to Done on the board: a merge into develop does not close it. -->
