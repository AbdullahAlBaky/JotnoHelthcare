# ML integration notes

Artifact: `ml-service/models/jotnohealthcare_general_disease_model.pkl`

Loaded with `joblib.load`. Keys: `model`, `binarizer`, `feature_names`, `target_name`, `model_name`, `dataset`, `metrics`, `training_note`. Model: RandomForestClassifier, 41 disease classes, 131 symptom features. Use `binarizer.transform([symptom_list])` before calling `model.predict`.

The artifact reports 100% for accuracy, macro/weighted precision, recall and F1. This is not evidence of clinical accuracy: the source dataset is template-like and deduplication leaves only a small set of unique symptom combinations. The saved note states that it is not clinically validated. The Flask API rejects symptoms not found in the saved feature set.

Suggested department is a lightweight keyword mapping, not a model output and not medical advice. It must be reviewed by a doctor.
