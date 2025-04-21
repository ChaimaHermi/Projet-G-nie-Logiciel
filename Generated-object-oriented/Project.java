/***********************************************************************
 * Module:  Project.java
 * Author:  ayeta
 * Purpose: Defines the Class Project
 ***********************************************************************/

import java.util.*;

/** @pdOid e80dcad8-857d-4a90-921a-ca6b5774b80f */
public class Project {
   /** @pdOid c4864e15-33c9-4f57-8ae5-c2f939c9d9e5 */
   private String name;
   /** @pdOid a9282825-f58e-4592-b01b-a0855f9ba931 */
   private String description;
   /** @pdOid c35ff78b-d7f6-4f02-8942-54bfb398567c */
   private String reference;
   /** @pdOid 9b9c940b-e0d2-4b4d-b9aa-b13e86a1e509 */
   private String notes;
   /** @pdOid 4c914e24-a28d-4225-bbb7-ecbba0732443 */
   private String files;
   /** @pdOid d507dd15-b9a3-4a9b-bab2-bcecdd95ec7f */
   private String image;
   /** @pdOid f896648b-ea16-444a-8614-2b33b7a06325 */
   private java.util.Date start_date;
   /** @pdOid bd7f5ebe-4371-44bb-b210-e3bc96b5f7a3 */
   private java.util.Date end_date;
   
   /** @pdRoleInfo migr=no name=Contractor assc=Association_8 coll=java.util.Collection impl=java.util.HashSet mult=1..1 */
   public Contractor contractor;

}