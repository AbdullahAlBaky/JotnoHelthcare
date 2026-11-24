# GitHub-এ contribution upload করার সহজ নিয়ম

## কোন ফাইল কোথায় যাবে

তোমাদের repository root-এ (যেখানে `frontend` এবং `backend` folder আছে) এইভাবে রাখবে:

```text
JotnoHelthcare/
├── README.md                         # এই প্যাকেজের README.md
├── docs/
│   ├── API_DOCUMENTATION.md
│   ├── DATABASE_DESIGN.md
│   └── TESTING_CHECKLIST.md
└── postman/
    └── JotnoHealthcare.postman_collection.json
```

`UPLOAD_GUIDE_BN.md` চাইলে root-এ রাখবে না; এটা তোমার নিজের নির্দেশিকা হিসেবে রাখতে পারো।

## GitHub website দিয়ে upload

1. GitHub repository খোলো: https://github.com/AbdullahAlBaky/JotnoHelthcare
2. `Add file` → `Upload files` চাপো।
3. এই প্যাকেজের ভেতরের `README.md`, `docs` folder-এর তিনটি ফাইল, এবং `postman` folder-এর JSON ফাইল select করে upload করো।
4. Commit message দাও: `Add project documentation and API testing collection`.
5. যদি দলের নিয়ম থাকে, আগে নতুন branch বানিয়ে Pull Request দাও। সরাসরি `main` branch-এ commit করার আগে অন্য দুই সদস্যের সঙ্গে কথা বলবে।

## Terminal দিয়ে upload (যদি Git ব্যবহার করো)

Contribution folder-এর ফাইলগুলো project-এর root-এ copy করার পর:

```bash
git checkout -b docs-api-testing-contribution
git add README.md docs/ postman/
git commit -m "Add project documentation and API testing collection"
git push -u origin docs-api-testing-contribution
```

তারপর GitHub-এ গিয়ে `Compare & pull request` চাপবে। Team owner review করে merge করবে।

## জমা দেওয়ার আগে

- README-র setup steps নিজের কম্পিউটারে চালিয়ে যাচাই করো।
- Postman-এ collection import করে local API-তে request চালাও।
- Testing checklist-এর `Not run` status বাস্তবে test না করে `Passed` লিখবে না।
- `.env`, password, token, database credentials বা real patient data কখনো upload করবে না।
