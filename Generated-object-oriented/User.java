/***********************************************************************
 * Module:  User.java
 * Author:  ayeta
 * Purpose: Defines the Class User
 ***********************************************************************/

import java.util.*;

/** @pdOid 6a05ad6b-86ae-497d-b715-3566b7c6dbfd */
public class User {
   /** @pdOid 2504983d-75e4-4f7f-b5d0-bf88d783b6df */
   private String first_name;
   /** @pdOid 6ebbbe14-d84b-4b3e-8181-29a5ac982f4d */
   private String last_name;
   /** @pdOid 5ce4aa7a-b119-4333-807f-43fd7186cbf0 */
   private String email;
   /** @pdOid 97fddb20-338b-4369-8465-ea6911141131 */
   private String status;
   /** @pdOid 5e8231e1-5fd9-4b9c-8b21-8ed062bb2f80 */
   private String password;
   /** @pdOid 35d330bf-be29-48d9-8e53-996a955ff6af */
   private String image;
   
   /** @pdRoleInfo migr=no name=Role assc=Association_1 coll=java.util.Collection impl=java.util.HashSet mult=1..1 */
   public Role role;
   /** @pdRoleInfo migr=no name=Assessment_work_plan assc=Association_3 coll=java.util.Collection impl=java.util.HashSet mult=0..* */
   public java.util.Collection<Assessment_work_plan> assessment_work_plan;
   
   
   /** @pdGenerated default getter */
   public java.util.Collection<Assessment_work_plan> getAssessment_work_plan() {
      if (assessment_work_plan == null)
         assessment_work_plan = new java.util.HashSet<Assessment_work_plan>();
      return assessment_work_plan;
   }
   
   /** @pdGenerated default iterator getter */
   public java.util.Iterator getIteratorAssessment_work_plan() {
      if (assessment_work_plan == null)
         assessment_work_plan = new java.util.HashSet<Assessment_work_plan>();
      return assessment_work_plan.iterator();
   }
   
   /** @pdGenerated default setter
     * @param newAssessment_work_plan */
   public void setAssessment_work_plan(java.util.Collection<Assessment_work_plan> newAssessment_work_plan) {
      removeAllAssessment_work_plan();
      for (java.util.Iterator iter = newAssessment_work_plan.iterator(); iter.hasNext();)
         addAssessment_work_plan((Assessment_work_plan)iter.next());
   }
   
   /** @pdGenerated default add
     * @param newAssessment_work_plan */
   public void addAssessment_work_plan(Assessment_work_plan newAssessment_work_plan) {
      if (newAssessment_work_plan == null)
         return;
      if (this.assessment_work_plan == null)
         this.assessment_work_plan = new java.util.HashSet<Assessment_work_plan>();
      if (!this.assessment_work_plan.contains(newAssessment_work_plan))
         this.assessment_work_plan.add(newAssessment_work_plan);
   }
   
   /** @pdGenerated default remove
     * @param oldAssessment_work_plan */
   public void removeAssessment_work_plan(Assessment_work_plan oldAssessment_work_plan) {
      if (oldAssessment_work_plan == null)
         return;
      if (this.assessment_work_plan != null)
         if (this.assessment_work_plan.contains(oldAssessment_work_plan))
            this.assessment_work_plan.remove(oldAssessment_work_plan);
   }
   
   /** @pdGenerated default removeAll */
   public void removeAllAssessment_work_plan() {
      if (assessment_work_plan != null)
         assessment_work_plan.clear();
   }

}