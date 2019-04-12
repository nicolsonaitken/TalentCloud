import React from "react";
import { injectIntl, InjectedIntlProps } from "react-intl";
import {
  Job,
  Criteria,
  Assessment,
  RatingsGuideQuestion,
  RatingsGuideAnswer,
} from "../types";
import { CriteriaTypeId } from "../lookupConstants";
import AssessmentPlanSkill from "./AssessmentPlanSkill";
import AssessmentPlanTable from "./AssessmentPlanTable";
import RatingsGuideBuilder from "./RatingsGuideBuilder";

interface AssessmentPlanProps {
  job: Job;
  criteria: Criteria[];
  assessments: Assessment[];
  questions: RatingsGuideQuestion[];
  answers: RatingsGuideAnswer[];
}

const renderAssessmentPlanSkill = (
  criterion: Criteria,
  assessments: Assessment[],
): React.ReactElement => {
  // Get the assessment type ids associated with this criterion
  const assementTypeIds = assessments
    .filter(assessment => assessment.criterion_id === criterion.id)
    .map(assessment => assessment.assessment_type_id);
  return (
    <AssessmentPlanSkill
      key={criterion.id}
      criterion={criterion}
      assessmentTypeIds={assementTypeIds}
      addAssessmentType={(assessmentTypeId: number) =>
        console.log(assessmentTypeId)
      }
      removeAssessmentType={(assessmentTypeId: number) =>
        console.log(assessmentTypeId)
      }
    />
  );
};

const AssessmentPlan: React.FunctionComponent<
  AssessmentPlanProps & InjectedIntlProps
> = ({
  job,
  criteria,
  assessments,
  questions,
  answers,
  intl,
}): React.ReactElement => {
  const assetCriteria = criteria.filter(
    criterion => criterion.criteria_type_id === CriteriaTypeId.Asset,
  );
  const essentialCriteria = criteria.filter(
    criterion => criterion.criteria_type_id === CriteriaTypeId.Essential,
  );

  return (
    <section data-clone>
      <div
        data-c-padding="top(triple) bottom(triple)"
        data-c-container="layout"
      >
        {/* Assessment & Rating Intro ==================================== */}
        <h3
          data-c-font-size="h3"
          data-c-font-weight="bold"
          data-c-margin="bottom"
        >
          Generate an assessment plan for:
          <span data-c-font-colour="c5" data-c-font-size="h3">
            {job.title}
          </span>
        </h3>
        <p data-c-margin="bottom(normal)">
          This tool allows you to build an assessment plan and a ratings guide
          for your job poster. The tool is used in 3 steps:
        </p>
        <ol data-c-margin="bottom(normal)">
          <li>
            <strong>Assessment Plan Builder</strong> (Select your assessments)
          </li>
          <li>
            <strong>Assessment Plan Summary</strong> (Review your plan)
          </li>
          <li>
            <strong>Ratings Guide Builder</strong> (Customize your evaluations)
          </li>
        </ol>
        <p>
          Please note that all assessment plans will include a review of the
          narrative evidence provided by the applicant.
        </p>
        <div
          data-c-alert="error"
          data-c-radius="rounded"
          data-c-padding="half"
          role="alert"
          data-c-margin="top(double)"
        >
          <span
            data-c-margin="bottom(quarter)"
            data-c-heading="h5"
            data-c-font-weight="bold"
          >
            <i aria-hidden="true" className="fa fa-exclamation-circle" />
            Optional Alert Title
          </span>

          <p>
            This is a sample error alert. These alerts are used to display
            critical system and form errors.
          </p>
        </div>
        {/* Assessment Plan Builder ====================================== */}
        <h3
          data-c-font-size="h3"
          data-c-font-weight="bold"
          data-c-margin="top(triple) bottom(normal)"
        >
          1. Assessment Plan Builder
        </h3>
        <p data-c-margin="bottom(normal)">
          Your first step is to pick some assessments that will allow you to
          evaluate the criteria you{"'"}ve selected for your job poster. Below
          you{"'"}ll find your essential criteria, followed by your asset
          criteria if you{"'"}ve selected any. The builder will save as you go,
          so when you{"'"}re finished, feel free to move to step 2 to review
          your work.
        </p>
        <div
          data-c-background="black(10)"
          data-c-border="all(thin, solid, black)"
          data-c-padding="top(normal) right(normal) left(normal)"
          data-c-margin="top(normal) bottom(normal)"
        >
          <h4
            data-c-font-colour="c5"
            data-c-font-weight="bold"
            data-c-font-size="h4"
          >
            Essential Skills
          </h4>
          <div
            data-c-radius="rounded"
            data-c-background="black(10)"
            data-c-border="all(thin, solid, black)"
            data-c-padding="normal"
            data-c-alignment="base(center)"
            data-c-margin="top(normal) bottom(normal)"
          >
            {essentialCriteria.map(criterion =>
              renderAssessmentPlanSkill(criterion, assessments),
            )}
            {essentialCriteria.length === 0 && (
              <span data-c-font-colour="black">
                You have no essential skills selected for this job poster.
              </span>
            )}
          </div>
          <h4
            data-c-font-colour="c5"
            data-c-font-weight="bold"
            data-c-font-size="h4"
          >
            Asset Skills
          </h4>
          <div
            data-c-radius="rounded"
            data-c-background="black(10)"
            data-c-border="all(thin, solid, black)"
            data-c-padding="normal"
            data-c-alignment="base(center)"
            data-c-margin="top(normal) bottom(normal)"
          >
            {assetCriteria.map(criterion =>
              renderAssessmentPlanSkill(criterion, assessments),
            )}
            {assetCriteria.length === 0 && (
              <span data-c-font-colour="black">
                You have no asset skills selected for this job poster.
              </span>
            )}
          </div>
        </div>
        {/* Generated Assessment Plan ==================================== */}
        <AssessmentPlanTable criteria={criteria} assessments={assessments} />
        {/* Ratings Guide Builder ======================================== */}
        <RatingsGuideBuilder
          criteria={criteria}
          assessments={assessments}
          questions={questions}
          answers={answers}
        />
      </div>
    </section>
  );
};

export default injectIntl(AssessmentPlan);