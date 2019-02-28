import React from "react";
import { Application, SavedStatus } from "../types";
import { SelectOption } from "../Select";
import { applicationCategory } from "./helpers";
import ReviewCategory from "./ReviewCategory";

interface ReviewApplicationsProps {
  title: string;
  classification: string;
  applications: Application[];
  reviewStatusOptions: SelectOption<number>[];
  onStatusChange: (applicationId: number, statusId: number | null) => void;
  onNotesChange: (applicationId: number, notes: string | null) => void;
  savedStatuses: { applicationId: number; savedStatus: SavedStatus }[];
  onSavedStatusChange: (applicationId: number, savedStatus: SavedStatus) => void;
}

const ReviewApplications: React.StatelessComponent<ReviewApplicationsProps> = (
  props
): React.ReactElement => {
  const categories = [
    {
      title: "Under Consideration",
      description: "Blah blah",
      showScreenOutAll: false,
      applications: props.applications.filter(
        application => applicationCategory(application) == "primary"
      )
    },
    {
      title: "Optional Consideration",
      description: "Blah blah",
      showScreenOutAll: true,
      applications: props.applications.filter(
        application => applicationCategory(application) == "optional"
      )
    },
    {
      title: "No Longer Under Consideration",
      description: "Blah blah",
      showScreenOutAll: false,
      applications: props.applications.filter(
        application => applicationCategory(application) == "screened-out"
      )
    }
  ];

  return (
    <section className="applicant-review container--layout-xl">
      <div className="flex-grid gutter">
        <div className="box med-1of2 job-title-wrapper">
          <span>
            Viewing Applicants for: {props.title} ({props.classification})
          </span>
        </div>

        <div className="box med-1of2 timer-wrapper">
          <span>
            <i className="fas fa-stopwatch" /> {/* Number */} Days Since Close
          </span>
        </div>
      </div>

      <div className="priority-alert">
        <h3>
          <i className="fas fa-bell" /> Temporary Priority Alert
        </h3>

        <p>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse
          luctus fermentum lorem, vel rhoncus velit vehicula imperdiet. Integer
          ullamcorper iaculis justo, quis tincidunt ex vulputate ut. Vivamus
          molestie augue turpis, ut egestas ante aliquam id. Quisque efficitur,
          metus imperdiet rhoncus pharetra, velit ligula lobortis tortor, vitae
          imperdiet leo augue ac velit. Vivamus sollicitudin dictum est a
          tempus. Fusce tempus finibus elit sed lacinia.
        </p>
      </div>
      {categories.map(category => (
        <ReviewCategory
          key={category.title}
          {...category}
          reviewStatusOptions={props.reviewStatusOptions}
          onStatusChange={props.onStatusChange}
          onNotesChange={props.onNotesChange}
          savedStatuses={props.savedStatuses}
          onSavedStatusChange={props.onSavedStatusChange}
        />
      ))}
    </section>
  );
};

export default ReviewApplications;
